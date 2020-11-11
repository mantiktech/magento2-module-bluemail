<?php

declare(strict_types=1);

namespace Mantik\Bluemail\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Mantik\Bluemail\Helper\Config;
use Mantik\Bluemail\Helper\Data;
use  Mantik\Bluemail\Model\BluemailApi\Delivery;

/**
 * Class ShipmentSaveAfter
 */
class ShipmentSaveAfter implements ObserverInterface
{

    /**
     * @var string
     */
    const URL_TRACKING = 'portal/envio/fiche.php?';

    protected $helper;
    protected $config;
    protected $delivery;
    protected $trackFactory;

    public function __construct(
        Delivery $delivery,
        Data $helper,
        TrackFactory $trackFactory,
        Config $config
    ) {
        $this->delivery = $delivery;
        $this->helper = $helper;
        $this->trackFactory = $trackFactory;
        $this->config = $config;
    }

    /**
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        $order = $shipment->getOrder();

        $method = substr($order->getShippingMethod(), strpos($order->getShippingMethod(), '_')+1);

        if (str_contains($method, \Mantik\Bluemail\Helper\Config::BLUEMAIL_CODE) && empty($shipment->getShippingLabel())) {
            $data = ["shipment" =>[
                 'serviceCode' => $method,
                 'packages' => $this->helper->getPackages($shipment->getAllItems()),
                 'destination' => $this->helper->getDestination($order),
                 'customerTrackingID' => $shipment->getIncrementId(),
                 'comments' => $order->getData('bluemail_notes')
                ]
            ];

            $this->delivery->cleanData();
            $this->delivery->execute($data);
            $response = $this->delivery->getResponse();
            if (isset($response['Shipment']['trackingId'])) {
                $tracking = [
                    'carrier_code' => \Mantik\Bluemail\Helper\Config::BLUEMAIL_CODE,
                    'title' => __('Bluemail'),
                    'number' => $response['Shipment']['trackingId'],
                    'carrier' => \Mantik\Bluemail\Helper\Config::BLUEMAIL_CODE

                ];
                $track = $this->trackFactory->create()->addData($tracking);
                $url = $this->config->getBlueMailUrl() . self::URL_TRACKING;
                $shipment->setShippingLabel($url . $response['Shipment']['id']);

                $shipment->addTrack($track)->save();
            }
        }
    }
}

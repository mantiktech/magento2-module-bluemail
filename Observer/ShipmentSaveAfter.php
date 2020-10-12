<?php

declare(strict_types=1);

namespace Mantik\Bluemail\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
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
    const code = 'bluemail';
    protected $helper;
    protected $delivery;
    protected $trackFactory;

    public function __construct(
        Delivery $delivery,
        Data $helper,
        TrackFactory $trackFactory
    ) {
        $this->delivery = $delivery;
        $this->helper = $helper;
        $this->trackFactory = $trackFactory;
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

        if (str_contains($method, self::code) && empty($shipment->getShippingLabel())) {
            $data = ["shipment" =>[
                 'serviceCode' => $method,
                 'packages' => $this->helper->getPackages($shipment->getAllItems()),
                 'destination' => $this->helper->getDestination($order)
                ]
            ];

            $this->delivery->cleanData();
            $this->delivery->execute($data);
            $response = $this->delivery->getResponse();
            if (isset($response['Shipment']['trackingId'])) {
                $tracking = [
                    'carrier_code' => $method,
                    'title' => __('Bluemail'),
                    'number' => $response['Shipment']['trackingId']

                ];
                $track = $this->trackFactory->create()->addData($tracking);

                $shipment->setShippingLabel($response['Shipment']['labelUrl']);

                $shipment->addTrack($track)->save();
            }
        }
    }
}

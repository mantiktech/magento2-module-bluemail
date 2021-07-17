<?php

namespace Mantik\Bluemail\Plugin\Block\Adminhtml\Order;


use Mantik\Bluemail\Helper\Config;

class View
{

    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function beforeGetOrderId(\Magento\Sales\Block\Adminhtml\Order\View $subject)
    {
        $order = $subject->getOrder();

        if (str_contains($order->getShippingMethod(), \Mantik\Bluemail\Helper\Config::BLUEMAIL_CODE) &&  $order->getShipmentsCollection()->getSize() > 0) {
            //$shipment = $order->getShipmentsCollection()->getFirstItem()->getShippingLabel();
            $shipment='http://envios.bluemail.com.ar/';
            $subject->addButton(
                'bluemail_pdf',
                ['label' => __('Print bluemail label'), 'onclick' => "window.open('" . $this->config->getBlueMailUrl() . "' , '_blank')"]
            );
        }
        return null;
    }
}

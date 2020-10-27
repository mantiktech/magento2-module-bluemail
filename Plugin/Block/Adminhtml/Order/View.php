<?php

namespace Mantik\Bluemail\Plugin\Block\Adminhtml\Order;

class View
{
    const code = 'bluemail';
    const URL_PDF = 'http://envios.bluemailbox.com.ar/';
    public function beforeGetOrderId(\Magento\Sales\Block\Adminhtml\Order\View $subject)
    {
        $order = $subject->getOrder();

        if (str_contains($order->getShippingMethod(), self::code) &&  $order->getShipmentsCollection()->getSize() > 0) {
            //$shipment = $order->getShipmentsCollection()->getFirstItem()->getShippingLabel();
            $shipment='http://envios.bluemailbox.com.ar/';
            $subject->addButton(
                'bluemail_pdf',
                ['label' => __('Print bluemail label'), 'onclick' => "window.open('" . self::URL_PDF . "' , '_blank')"]
            );
        }
        return null;
    }
}

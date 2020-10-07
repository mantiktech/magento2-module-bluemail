<?php

namespace Mantik\Bluemail\Plugin\Block\Adminhtml\Order;


class View
{
    const code = 'bluemail';

    public function beforeGetOrderId(\Magento\Sales\Block\Adminhtml\Order\View $subject)
    {
        $order = $subject->getOrder();

        if (str_contains($order->getShippingMethod(), self::code) &&  $order->getShipmentsCollection()->getSize() > 0) {
            $shipment = $order->getShipmentsCollection()->getFirstItem()->getShippingLabel();
            $subject->addButton(
                'bluemail_pdf',
                ['label' => __('Generate bluemail label'), 'onclick' => "window.open('$shipment' , '_blank')"]
            );
        }
        return null;
    }
}

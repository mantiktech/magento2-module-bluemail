<?php

namespace Mantik\Bluemail\Plugin\Block\Adminhtml\Shipping\View;

use Mantik\Bluemail\Helper\Config;

class Form
{

    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function aroundGetPrintLabelButton(\Magento\Shipping\Block\Adminhtml\View\Form $subject, callable $proceed)
    {
        $data['shipment_id'] = $subject->getShipment()->getId();
        if (str_contains($subject->getOrder()->getShippingMethod(), \Mantik\Bluemail\Helper\Config::BLUEMAIL_CODE)) {
            $url = $this->config->getBlueMailUrl();
            return $subject->getLayout()->createBlock(
                \Magento\Backend\Block\Widget\Button::class
            )->setData(
                ['label' => __('Print Shipping Label'), 'onclick' => 'window.open(\'' . $url . '\',\'_blank\')']
            )->toHtml();
        } else {
            $url = $subject->getUrl('adminhtml/order_shipment/printLabel', $data);
            return $subject->getLayout()->createBlock(
                \Magento\Backend\Block\Widget\Button::class
            )->setData(
                ['label' => __('Print Shipping Label'), 'onclick' => 'setLocation(\'' . $url . '\')']
            )->toHtml();
        }

    }
}

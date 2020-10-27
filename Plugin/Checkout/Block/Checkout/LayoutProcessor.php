<?php
namespace Mantik\Bluemail\Plugin\Checkout\Block\Checkout;
class LayoutProcessor
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-shipping-method-form']['children']['bluemail_notes'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/textarea',
                'options' => [],
                'id' => 'bluemail-notes'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.bluemail_notes',
            'label' => __('Bluemail Notes'),
            'provider' => 'checkoutProvider',
            'visible' => false,
            'validation' => [],
            'sortOrder' => 999999,
            'id' => 'bluemail-notes'
        ];


        return $jsLayout;
    }
}


define(['jquery','Magento_Checkout/js/checkout-data'], function ($,checkoutData) {
    'use strict';

    var cache = [];

    return {
        /**
         * @param {String} addressKey
         * @return {*}
         */
        get: function (addressKey) {
            if (cache[addressKey]) {
                return cache[addressKey];
            }

            return false;
        },

        /**
         * @param {String} addressKey
         * @param {*} data
         */
        set: function (addressKey, data) {
            cache[addressKey] = data;
            if (checkoutData.getSelectedShippingRate() && checkoutData.getSelectedShippingRate().indexOf('bluemail')!=-1){
                $('[name="shippingAddress.custom_attributes.bluemail_notes"]').css('display','block');
            }
            setTimeout(function(){ $('[name="shippingAddress.custom_attributes.bluemail_notes"]').appendTo($('#checkout-shipping-method-load')) }, 300);
        }
    };
});

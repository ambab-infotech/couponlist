define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/action/set-shipping-information',
    'Magento_SalesRule/js/view/payment/discount',
    'Magento_Checkout/js/model/quote',
    'mage/translate'
    ], function($, Component, ko, setShippingAction, discount, quote, $t
    ) {

    var itemList = ko.observableArray(),
        couponCode = ko.observable(null),
        totals = quote.getTotals(),
        readMoreElement = ko.observable(null);

    if (totals()) {
        couponCode(totals()['coupon_code']);
    }

    itemList = ko.observableArray(window.checkoutConfig.couponList);

    return Component.extend({
        defaults: {
            template: 'Ambab_CouponList/coupon/list'
        },
         
        itemList:itemList,
        couponCode: couponCode,
        readMoreElement: readMoreElement,
        couponCodeSelector: "#coupon_code",
        removeCouponSelector: "#remove-coupon",
        applyButton: "button.action.apply",
        cancelButton: "button.action.cancel",

        initialize: function() {
            self = this;
            this._super();
        },

        applycoupon: function(coupon) {
            discount().couponCode(coupon.coupon);
            discount().apply();
            couponCode(coupon.coupon);
            if(totals()['shipping_amount']>0) {
                setShippingAction([]);
            }
            self.updateCartDiscountBlock();  
        },

        cancelcoupon: function() {
            discount().couponCode('');
            discount().cancel();
            couponCode('');
            if(totals()['shipping_amount']>0) {
                setShippingAction([]);
            }
            self.updateCartDiscountBlock();
        },

        readMoreToggle: function(coupon) {
            readMoreElement(coupon.coupon);
        },

        readLessToggle: function() {
            readMoreElement(null);
        },

        updateCartDiscountBlock: function() {
            if(discount().couponCode()) {
                $(self.couponCodeSelector).attr('disabled', 'disabled');
                $(self.couponCodeSelector).attr('value', discount().couponCode());
                $(self.applyButton).removeClass('apply').addClass('cancel');
                $(self.removeCouponSelector).attr('value', '1');
                $(self.cancelButton).attr('value', $t('Cancel Coupon'));
                $(self.cancelButton+' span').html($t('Cancel Coupon'));
            } else {
                $(self.couponCodeSelector).removeAttr('disabled', 'disabled');
                $(self.couponCodeSelector).attr('value', '');
                $(self.cancelButton).removeClass('cancel').addClass('apply');
                $(self.removeCouponSelector).attr('value', '0');
                $(self.applyButton).attr('value', $t('Apply Coupon'));
                $(self.applyButton+' span').html($t('Apply Coupon'));
            }
        }
      
    });

});

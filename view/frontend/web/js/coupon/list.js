define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/action/set-shipping-information',
    'Magento_SalesRule/js/view/payment/discount',
    'Magento_SalesRule/js/action/set-coupon-code',
    'Magento_SalesRule/js/action/cancel-coupon',
    'Magento_Checkout/js/model/quote',
    'mage/translate'
    ], function($, Component, ko, setShippingAction, discount, setCouponCodeAction, cancelCouponAction, quote, $t
    ) {

    var itemList = ko.observableArray(),
        couponCode = ko.observable(null),
        totals = quote.getTotals(),
        readMoreElement = ko.observable(null),
        isApplied;

    if (totals()) {
        couponCode(totals()['coupon_code']);
    }

    isApplied = ko.observable(couponCode() != null);
    itemList = ko.observableArray(window.checkoutConfig.couponList);

    return Component.extend({
        defaults: {
            template: 'Ambab_CouponList/coupon/list'
        },
         
        itemList:itemList,
        couponCode: couponCode,
        readMoreElement: readMoreElement,
        isApplied: isApplied,
        couponCodeSelector: "#coupon_code",
        removeCouponSelector: "#remove-coupon",
        applyButton: "button.action.apply",
        cancelButton: "button.action.cancel",
        modalPopup: ".coupon-list-view-popup",

        initialize: function() {
            self = this;
            this._super();

            discount().isApplied.subscribe(function() {
                if(discount().couponCode() != '') {
                    couponCode(discount().couponCode());
                } else {
                    couponCode('');
                }
            });
        },

        applycoupon: function(coupon) {
            var deferred = setCouponCodeAction(coupon.coupon, isApplied);
            $.when(deferred).done(function () {
                discount().couponCode(coupon.coupon);
                discount().isApplied(true);
                couponCode(coupon.coupon);
                if(totals()['shipping_amount']>0) {
                    setShippingAction([]);
                }
                self.updateCartDiscountBlock();
                self.closePopup();
            });
        },

        cancelcoupon: function() {
            couponCode('');
            var deferred = cancelCouponAction(isApplied);
            $.when(deferred).done(function () {
                discount().couponCode('');
                discount().isApplied(false);
                if(totals()['shipping_amount']>0) {
                    setShippingAction([]);
                }
                self.updateCartDiscountBlock();
                self.closePopup();
            });
        },

        closePopup: function() {
            $(self.modalPopup).modal('closeModal');
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

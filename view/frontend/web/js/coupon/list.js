define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/action/set-shipping-information',
    'Magento_SalesRule/js/action/set-coupon-code',
    'Magento_SalesRule/js/action/cancel-coupon'
    ], function($,Component, ko, quote, setShippingAction, setCouponCodeAction, cancelCouponAction
    ) {

    var itemList = ko.observableArray(),
        totals = quote.getTotals(),
        couponCode = ko.observable(null),
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
        isApplied: isApplied,

        initialize: function() {
            this._super();
        },

        applycoupon: function(coupon) {
            setCouponCodeAction(coupon.coupon, isApplied);
            setShippingAction([]);
        },

        cancelcoupon: function() {
            couponCode('');
            cancelCouponAction(isApplied);
            setShippingAction([]);
        }
        
    });

});
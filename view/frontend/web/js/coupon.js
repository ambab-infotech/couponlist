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

    return Component.extend({
        defaults: {
            template: 'Ambab_CouponList/coupon'
        },
         
        itemList:itemList,
        couponCode: couponCode,
        isApplied: isApplied,

        initialize: function() {
            this._super();
            this.populateCouponList();
        },

        populateCouponList: function() {
            var self =  this;
            if(this.itemList().length <1) {
                this.itemList(this.getcouponList());
            }
        },

        getcouponList: function() {
            return this.couponList;
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
<?php

namespace Ambab\CouponList\Api;

/**
 * Coupon list interface for guest carts.
 *
 * @api
 *
 * @since 1.0.0
 */
interface GuestCouponListInterface
{
    /**
     * Return list of valid coupon in a specified cart.
     *
     * @param string $cartId the cart ID
     *
     * @return string the coupon list data
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException the specified cart does not exist
     */
    public function get($cartId);
}

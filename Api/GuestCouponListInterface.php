<?php
/**
 * Ambab CouponList Extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ambab
 *
 * @copyright   Copyright (c) 2019 Ambab (https://www.ambab.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

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
     * @return string[] the coupon list data
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException the specified cart does not exist
     */
    public function get($cartId);
}

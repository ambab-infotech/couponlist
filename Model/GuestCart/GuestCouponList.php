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

namespace Ambab\CouponList\Model\GuestCart;

use Ambab\CouponList\Api\CouponListInterface;
use Ambab\CouponList\Api\GuestCouponListInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;

/**
 * Coupon list class for guest carts.
 */
class GuestCouponList implements GuestCouponListInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * @var CouponListInterface
     */
    private $couponList;

    /**
     * Constructs a coupon read service object.
     */
    public function __construct(
        CouponListInterface $couponList,
        QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->couponList = $couponList;
    }

    /**
     * {@inheritdoc}
     */
    public function get($cartId)
    {
        /** @var $quoteIdMask QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');

        return $this->couponList->get($quoteIdMask->getQuoteId());
    }
}

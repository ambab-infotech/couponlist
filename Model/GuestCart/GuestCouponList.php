<?php

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

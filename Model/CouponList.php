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

namespace Ambab\CouponList\Model;

use Ambab\CouponList\Api\CouponListInterface;

/**
 * Coupon list object.
 */
class CouponList implements CouponListInterface
{
    /**
     * Quote repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * Sales Rules collection.
     *
     * @var \Ambab\CouponList\Model\Rule\Collection
     */
    protected $ruleCollection;

    /**
     * Constructs a coupon read service object.
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Ambab\CouponList\Model\Rule\Collection $ruleCollection
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->ruleCollection = $ruleCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function get($cartId)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        return $this->ruleCollection->getValidCouponList($quote);
    }
}

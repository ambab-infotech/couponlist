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

namespace Ambab\CouponList\Model\Checkout;

use Magento\Checkout\Model\ConfigProviderInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \Ambab\CouponList\Model\Rule\Collection
     */
    protected $_ruleCollection;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        \Ambab\CouponList\Model\Rule\Collection $ruleCollection,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_ruleCollection = $ruleCollection;
        $this->_checkoutSession = $checkoutSession;
    }

    /**
     * Provides checkout configurations for coupon code list.
     */
    public function getConfig()
    {
        $couponList['couponList'] = $this->getListArray();

        return $couponList;
    }

    /**
     * get List of valid coupon code for active cart.
     */
    public function getListArray()
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->_checkoutSession->getQuote();

        return $this->_ruleCollection->getValidCouponList($quote);
    }
}

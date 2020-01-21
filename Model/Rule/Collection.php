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

namespace Ambab\CouponList\Model\Rule;

class Collection
{
    /**
     * @var \Ambab\CouponList\Helper\Data
     */
    protected $_helperData;

    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory
     */
    protected $_utility;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        \Ambab\CouponList\Helper\Data $helperData,
        \Magento\SalesRule\Model\Utility $utility,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
    ) {
        $this->_helperData = $helperData;
        $this->_utility = $utility;
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * Get rules collection for current object state.
     *
     * @return \Magento\SalesRule\Model\ResourceModel\Rule\Collection
     */
    public function getRulesCollection()
    {
        $websiteId = $this->_helperData->getWebsiteId();
        $customerGroupId = $this->_helperData->getCustomerGroupId();

        return $this->_collectionFactory->create()
                ->addWebsiteGroupDateFilter($websiteId, $customerGroupId)
                ->addAllowedSalesRulesFilter()
                ->addFieldToFilter('coupon_type', ['neq' => '1'])
                ->addFieldToFilter('is_visible_in_list', ['eq' => '1']);
    }

    /**
     * Filter Sales rules with condition and return valid coupons only.
     *
     * @return string[] couponCodeArray
     */
    public function getValidCouponList($quote)
    {
        $address = $quote->getShippingAddress();
        $rules = $this->getRulesCollection();
        $ruleArray = [];

        $items = $quote->getAllVisibleItems();

        foreach ($rules as $rule) {
            $validate = $this->_utility->canProcessRule($rule, $address);

            $validAction = false;

            foreach ($items as $item) {
                if ($validAction = $rule->getActions()->validate($item)) {
                    break;
                }
            }

            if ($validate && $validAction) {
                $ruleArray[] = [
                    'name' => $rule->getName(),
                    'description' => $rule->getDescription(),
                    'coupon' => $rule->getCode(),
                ];
            }
        }

        return $ruleArray;
    }
}

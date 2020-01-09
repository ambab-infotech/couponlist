<?php

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
     * @return array couponCodeArray
     */
    public function getValidCouponList($quote)
    {
        $address = $quote->getShippingAddress();
        $rules = $this->getRulesCollection();
        $ruleArray = [];

        foreach ($rules as $rule) {
            $validate = $this->_utility->canProcessRule($rule, $address);

            if ($validate) {
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

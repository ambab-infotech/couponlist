<?php

namespace Ambab\CouponList\Block\Cart;

class CouponList extends \Magento\Checkout\Block\Cart\Coupon
{
    /**
     * @var \Ambab\CouponList\Model\Rule\Collection
     */
    protected $_ruleCollection;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Ambab\CouponList\Model\Rule\Collection $ruleCollection,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $data);
        $this->_jsonEncoder = $jsonEncoder;
        $this->_ruleCollection = $ruleCollection;
    }

    /**
     * Get Checkout Coupon List.
     */
    public function getCouponList()
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->getQuote();
        $ruleArray = $this->_ruleCollection->getValidCouponList($quote);

        return $this->_jsonEncoder->encode($ruleArray);
    }
}

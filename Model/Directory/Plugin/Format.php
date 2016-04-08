<?php
namespace Magejapan\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;

class Format
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * ModifyPrice constructor.
     * @param \Magento\Framework\View\Element\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
    }

    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param \Closure $proceed
     * @param $amount
     * @param bool $includeContainer
     * @param int $precision
     * @param null $scope
     * @param null $currency
     * @return mixed
     */
    public function aroundFormat(PriceCurrency  $subject,
        \Closure $proceed,
        $amount,
        $includeContainer = true,
        $precision = \Magento\Directory\Model\PriceCurrency::DEFAULT_PRECISION,
        $scope = null,
        $currency = null
    )
    {
        if($subject->getCurrency()->getCode() == 'JPY') {
            $precision = '0';
        }
        return $proceed($amount, $includeContainer, $precision, $scope, $currency);
    }
}
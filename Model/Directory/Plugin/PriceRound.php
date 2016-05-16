<?php
namespace Veriteworks\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;
use Veriteworks\Localize\Helper\Data;

/**
 * Class PriceRound
 * @package Veriteworks\Localize\Model\Directory\Plugin
 */
class PriceRound
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Veriteworks\Localize\Helper\Data
     */
    protected $_helper;

    /**
     * ModifyPrice constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Veriteworks\Localize\Helper\Data $helper
     */
    public function __construct(
        Data $helper,
        \Magento\Framework\View\Element\Context $context
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_helper = $helper;
    }


    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param \Closure $proceed
     * @param $amount
     * @param null $scope
     * @param null $currency
     * @param int $precision
     * @return mixed
     */
    public function aroundConvertAndRound(PriceCurrency  $subject,
                                \Closure $proceed,
                                $amount,
                                $scope = null,
                                $currency = null,
                                $precision = PriceCurrency::DEFAULT_PRECISION)
    {
        if($subject->getCurrency()->getCode() == 'JPY') {
            /** @var string $method */
            $method = $this->_helper->getRoundMethod($scope);

            if($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $scope, $currency, $precision);
    }


    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param \Closure $proceed
     * @param $amount
     * @param int $precision
     * @return mixed
     */
    public function aroundRound(PriceCurrency  $subject,
        \Closure $proceed,
        $amount,
        $precision=2)
    {
        if($subject->getCurrency()->getCode() == 'JPY') {
            /** @var string $method */
            $method = $this->_helper->getRoundMethod();
            if($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $precision);
    }

}
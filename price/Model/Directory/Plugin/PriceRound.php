<?php
namespace Veriteworks\Price\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;
use Veriteworks\Price\Helper\Data;

/**
 * Class PriceRound
 * @package Veriteworks\Price\Model\Directory\Plugin
 */
class PriceRound
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Veriteworks\Price\Helper\Data
     */
    private $helper;

    /**
     * ModifyPrice constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Veriteworks\Price\Helper\Data $helper
     */
    public function __construct(
        Data $helper,
        \Magento\Framework\View\Element\Context $context
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->helper = $helper;
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
            $method = $this->helper->getRoundMethod($scope);

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
            $method = $this->helper->getRoundMethod();
            if($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $precision);
    }

}
<?php
/**
 * Plugin for modifying price round
 *
 * PHP version 5, 7
 *
 * @category Plugin
 * @package  Veriteworks\Price\Model\Directory\Plugin
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;
use Veriteworks\Price\Helper\Data;

/**
 * Class PriceRound
 *
 * @category Plugin
 * @package  Veriteworks\Price\Model\Directory\Plugin
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class PriceRound
{

    /**
     * ScopeConfig
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Helper
     *
     * @var \Veriteworks\Price\Helper\Data
     */
    protected $helper;

    /**
     * ModifyPrice constructor.
     *
     * @param Data                                    $helper  Helper
     * @param \Magento\Framework\View\Element\Context $context Context
     */
    public function __construct(
        Data $helper,
        \Magento\Framework\View\Element\Context $context
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->helper = $helper;
    }


    /**
     * Modify rounding method for converting currency
     *
     * @param PriceCurrency $subject   Price Currency
     * @param \Closure      $proceed   Closure
     * @param float         $amount    Price
     * @param null          $scope     Configuration Scope
     * @param null          $currency  Currency
     * @param int           $precision Currency Precision
     *
     * @return mixed
     */
    public function aroundConvertAndRound(
        PriceCurrency  $subject,
        \Closure $proceed,
        $amount,
        $scope = null,
        $currency = null,
        $precision = PriceCurrency::DEFAULT_PRECISION
    ) {
        if ($subject->getCurrency()->getCode() == 'JPY') {
            /**
             * Rounding method
             *
             * @var string $method rounding method
             */
            $method = $this->helper->getRoundMethod($scope);

            if ($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $scope, $currency, $precision);
    }


    /**
     * Modify rounding method
     *
     * @param PriceCurrency $subject   Price Currency
     * @param \Closure      $proceed   Closure
     * @param float         $amount    Price
     * @param int           $precision Currency precision
     *
     * @return mixed
     */
    public function aroundRound(PriceCurrency  $subject,
        \Closure $proceed,
        $amount,
        $precision = 2
    ) {
        if ($subject->getCurrency()->getCode() == 'JPY') {
            /**
             * Rounding method
             *
             * @var string $method rounding method
             */
            $method = $this->helper->getRoundMethod();
            if ($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $precision);
    }

}
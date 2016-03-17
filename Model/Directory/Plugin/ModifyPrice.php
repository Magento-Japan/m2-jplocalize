<?php
namespace Magejapan\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;

class ModifyPrice
{

    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param \Closure $proceed
     * @param $amount
     * @param int $precision
     * @return float
     */
    public function aroundRound(PriceCurrency  $subject,
                                \Closure $proceed,
                                $amount,
                                $precision=2)
    {
        //todo: detect currency.
        if($subject->getCurrency()->getCode() == 'JPY') {
            return floor($amount);
        }
        return $proceed($amount, $precision);
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
            $precision = 0;
        }
        return $proceed($amount, $includeContainer, $precision, $scope, $currency);
    }
}
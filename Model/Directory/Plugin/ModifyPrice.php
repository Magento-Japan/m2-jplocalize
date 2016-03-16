<?php
namespace Magejapan\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;
use Magento\Directory\Model\Currency;

class ModifyPrice
{

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

    public function aroundFormatPrecision(Currency  $subject,
                                 \Closure $proceed,
                                $price,
                                $precision = 2,
                                $options,
                                $includeContainer,
                                $addBrackets
    )
    {
        if($subject->getCode() == 'JPY') {
            $precision = 0;
        }
        return $proceed($price, $precision, $options, $includeContainer, $addBrackets);
    }
}
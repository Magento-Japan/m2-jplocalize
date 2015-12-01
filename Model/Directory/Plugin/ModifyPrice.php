<?php
namespace Magejapan\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;

class ModifyPrice
{

    public function aroundRound(PriceCurrency  $subject,
                                \Closure $proceed,
                                $object)
    {
        //todo: detect currency.
        return floor($object);
    }

    public function aroundFormat(PriceCurrency  $subject,
                                 \Closure $proceed,
                                 $amount,
                                 $includeContainer,
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
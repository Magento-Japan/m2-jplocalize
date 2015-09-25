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
                                $object)
    {
        //todo: execute format with no precision
        //$subject->getCurrency()
        return $object;
    }
}
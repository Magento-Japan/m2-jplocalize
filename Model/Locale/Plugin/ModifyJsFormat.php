<?php
namespace Magejapan\Localize\Model\Locale\Plugin;

use Magento\Framework\Locale\Format;

class ModifyJsFormat
{

    public function aroundGetPriceFormat(Format $subject,
                                 $result)
    {
        if($subject->getCurrency()->getCode() == 'JPY') {
            $precision = 0;
        }
        return $proceed($amount, $includeContainer, $precision, $scope, $currency);
    }
}
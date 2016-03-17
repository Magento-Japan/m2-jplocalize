<?php
namespace Magejapan\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\Currency;

class ModifyPrecision
{

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
            if(isset($options['precision']))
            {
                $options['precision'] = 0;
            }
        }
        return $proceed($price, $precision, $options, $includeContainer, $addBrackets);
    }

}
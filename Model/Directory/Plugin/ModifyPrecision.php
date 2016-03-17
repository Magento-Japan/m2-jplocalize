<?php
namespace Magejapan\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\Currency;

class ModifyPrecision
{

    /**
     * @param \Magento\Directory\Model\Currency $subject
     * @param \Closure $proceed
     * @param $price
     * @param int $precision
     * @param $options
     * @param bool $includeContainer
     * @param bool $addBrackets
     * @return mixed
     */
    public function aroundFormatPrecision(Currency  $subject,
                                 \Closure $proceed,
                                $price,
                                $precision = 2,
                                $options,
                                $includeContainer = true,
                                $addBrackets = false
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
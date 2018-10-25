<?php
namespace Veriteworks\Kana\Plugin\Quote\Model\Quote\Address;

use Magento\Quote\Model\Quote\Address\CustomAttributeList;

/**
 * Class AppendKana
 * @package Veriteworks\Kana\Quote\Model\Quote\Address
 */
class AppendKana
{


    /**
     * @param \Magento\Quote\Model\Quote\Address $subject
     * @param $attributes
     */
    public function beforeSetCustomAttributes(
        \Magento\Quote\Model\Quote\Address $subject,
        $attributes
    ) {
        foreach ($attributes as $code => $data) {
            if(in_array($code, ['firstnamekana', 'lastnamekana'])) {
                $subject->setData($code, $data->getValue());
            }
        }
    }
}
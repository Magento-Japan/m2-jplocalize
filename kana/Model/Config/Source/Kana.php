<?php
namespace Veriteworks\Kana\Model\Config\Source;

class Kana implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve possible customer address types
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '1' => __('Only Katakana'),
            '2' => __('Only Hiragana'),
            '0' => __('Both')
        ];
    }
}
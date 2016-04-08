<?php
namespace Magejapan\Localize\Model\Config\Source;

class Round implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve possible customer address types
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            'round' => __('Round'),
            'ceil' => __('Ceil'),
            'floor' => __('Floor')
        ];
    }
}
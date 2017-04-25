<?php
/**
 * Configuration array generator class
 *
 * PHP version 5, 7
 *
 * @category Config
 * @package  Veriteworks\Price\Model\Config\Source
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Model\Config\Source;


/**
 * Class Position
 *
 * @category Config
 * @package  Veriteworks\Price\Model\Config\Source
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class Position implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Retrieve possible customer address types
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            16 => __('Right and use Kanji'),
            32 => __('Left and use symbol')
        ];
    }
}
<?php
/**
 * Plugin for price format
 *
 * PHP version 5, 7
 *
 * @category Plugin
 * @package  Veriteworks\Price\Model\Directory\Plugin
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Model\Directory\Plugin;

use Magento\Directory\Model\Currency;
use Veriteworks\Price\Helper\Data;

/**
 * Class Precision
 *
 * @category Plugin
 * @package  Veriteworks\Price\Model\Directory\Plugin
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class Precision
{
    /**
     * Helper
     *
     * @var \Veriteworks\Price\Helper\Data
     */
    private $helper;

    /**
     * Precision constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Modify price precision for JPY
     *
     * @param Currency $subject          Currency Object
     * @param \Closure $proceed          Closure
     * @param float    $price            Price
     * @param int      $precision        Currency Precision
     * @param array    $options          Currency options array
     * @param bool     $includeContainer Include container flag
     * @param bool     $addBrackets      Add brackets flag
     *
     * @return mixed
     */
    public function aroundFormatPrecision(
        Currency  $subject,
        \Closure $proceed,
        $price,
        $precision = 2,
        $options = [],
        $includeContainer = true,
        $addBrackets = false
    ) {
        if ($subject->getCode() == 'JPY') {
            $precision = '0';
            if (isset($options['precision'])) {
                $options['precision'] = '0';
            }
        }
        return $proceed(
            $price,
            $precision,
            $options,
            $includeContainer,
            $addBrackets);
    }

    /**
     * Modify Currency Position
     *
     * @param Currency $subject
     * @param \Closure $proceed
     * @param $price
     * @param array $options
     * @return mixed
     */
    public function aroundFormatTxt(
        Currency  $subject,
        \Closure $proceed,
        $price,
        $options = []
    )
    {
        if ($subject->getCode() == 'JPY') {
            $position = $this->helper->getSymbolPosition();
            $options['position'] = (int)$position;
            if($options['position'] == \Zend_Currency::RIGHT) {
                $options['symbol'] = __('Yen');
            }
        }

        return $proceed(
            $price,
            $options
        );
    }

}
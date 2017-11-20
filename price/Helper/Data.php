<?php
/**
 * Helper
 *
 * PHP version 5, 7
 *
 * @category Helper
 * @package  Veriteworks\Price\Helper
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 *
 * @category Helper
 * @package  Veriteworks\Price\Helper
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class Data extends AbstractHelper
{
    /**
     * Get rounding method value
     *
     * @return mixed
     */
    public function getRoundMethod()
    {
        return $this->scopeConfig->getValue(
            'tax/calculation/round',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getSymbolPosition()
    {
        return $this->scopeConfig->getValue(
            'price/symbol/position',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getIntegerCurrencies()
    {
        return [
            'BIF',
            'MGA',
            'CLP',
            'DJF',
            'PYG',
            'RWF',
            'GNF',
            'JPY',
            'VND',
            'VUV',
            'XAF',
            'KMF',
            'XOF',
            'KRW',
            'XPF',
            'TWD'
        ];
    }
}

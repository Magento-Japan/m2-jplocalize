<?php
/**
 * Observer for modify currency options
 *
 * PHP version 5, 7
 *
 * @category Observer
 * @package  Veriteworks\Price\Observer
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Observer;

use \Magento\CurrencySymbol\Model\System\CurrencysymbolFactory;
use Magento\Framework\Event\ObserverInterface;
use Veriteworks\Price\Helper\Data;

/**
 * Class ModifyCurrencyOptions
 *
 * @category Observer
 * @package  Veriteworks\Price\Observer
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class ModifyCurrencyOptions implements ObserverInterface
{
    /**
     * Currency symbol factory
     *
     * @var CurrencysymbolFactory
     */
    protected $symbolFactory;

    private $helper;

    /**
     * Constructor
     *
     * @param CurrencysymbolFactory $symbolFactory Currency Symbol Factory
     * @param Data $helper
     */
    public function __construct(
        CurrencysymbolFactory $symbolFactory,
        Data $helper
    ) {
        $this->symbolFactory = $symbolFactory;
        $this->helper = $helper;
    }

    /**
     * Generate options for currency displaying with custom currency symbol
     *
     * @param \Magento\Framework\Event\Observer $observer Observer
     *
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $baseCode = $observer->getEvent()->getBaseCode();
        $currencyOptions = $observer->getEvent()->getCurrencyOptions();
        $originalOptions = $currencyOptions->getData();
        $currencyOptions->setData(
            $this->getCurrencyOptions(
                $baseCode,
                $originalOptions
            )
        );

        return $this;
    }

    /**
     * Get currency display options
     *
     * @param string $baseCode        Base currency code
     * @param array  $originalOptions Currency Options
     *
     * @return array
     */
    protected function getCurrencyOptions($baseCode, $originalOptions)
    {
        $currencyOptions = [];
        if (in_array($baseCode, $this->helper->getIntegerCurrencies())) {
            $currencyOptions['precision'] = '0';
        }

        return array_merge($originalOptions, $currencyOptions);
    }
}

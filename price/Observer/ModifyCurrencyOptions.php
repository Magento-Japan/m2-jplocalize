<?php
namespace Veriteworks\Price\Observer;

use Magento\Framework\Locale\Currency;
use Magento\Framework\Event\ObserverInterface;

class ModifyCurrencyOptions implements ObserverInterface
{
    /**
     * @var \Magento\CurrencySymbol\Model\System\CurrencysymbolFactory
     */
    protected $symbolFactory;

    /**
     * @param \Magento\CurrencySymbol\Model\System\CurrencysymbolFactory $symbolFactory
     */
    public function __construct(\Magento\CurrencySymbol\Model\System\CurrencysymbolFactory $symbolFactory)
    {
        $this->symbolFactory = $symbolFactory;
    }

    /**
     * Generate options for currency displaying with custom currency symbol
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $baseCode = $observer->getEvent()->getBaseCode();
        $currencyOptions = $observer->getEvent()->getCurrencyOptions();
        $originalOptions = $currencyOptions->getData();
        $currencyOptions->setData($this->getCurrencyOptions($baseCode, $originalOptions));

        return $this;
    }

    /**
     * Get currency display options
     *
     * @param string $baseCode
     * @param array $originalOptions
     * @return array
     */
    protected function getCurrencyOptions($baseCode, $originalOptions)
    {
        $currencyOptions = [];
        if ($baseCode == 'JPY') {
            $currencyOptions['precision'] = '0';
        }

        return array_merge($originalOptions, $currencyOptions);
    }
}

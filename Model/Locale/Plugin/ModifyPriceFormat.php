<?php
namespace Veriteworks\Localize\Model\Locale\Plugin;

use Magento\Framework\Locale\Format;

class ModifyPriceFormat
{
    /**
     * @var \Magento\Framework\App\ScopeResolverInterface
     */
    protected $_scopeResolver;

    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_localeResolver;

    /**
     * @var \Magento\Directory\Model\CurrencyFactory
     */
    protected $currencyFactory;

    /**
     * @param \Magento\Framework\App\ScopeResolverInterface $scopeResolver
     * @param ResolverInterface $localeResolver
     * @param \Magento\Directory\Model\CurrencyFactory $currencyFactory
     */
    public function __construct(
        \Magento\Framework\App\ScopeResolverInterface $scopeResolver,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory
    ) {
        $this->_scopeResolver = $scopeResolver;
        $this->_localeResolver = $localeResolver;
        $this->currencyFactory = $currencyFactory;
    }

    public function aroundGetPriceFormat(Format $subject,
                                        \Closure $proceed,
                                        $localeCode = null,
                                        $currencyCode = null)
    {
        if ($currencyCode) {
            $currency = $this->currencyFactory->create()->load($currencyCode);
        } else {
            $currency = $this->_scopeResolver->getScope()->getCurrentCurrency();
        }

        $result = $proceed($localeCode, $currencyCode);

        if($currency->getCode() == 'JPY') {
            $result['precision'] = '0';
            $result['requiredPrecision'] = '0';
        }
        return $result;
    }
}
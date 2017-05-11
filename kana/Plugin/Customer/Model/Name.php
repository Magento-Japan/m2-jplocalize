<?php
namespace Veriteworks\Kana\Plugin\Customer\Model;

use \Magento\Customer\Model\Customer;
use \Magento\Eav\Model\Config;

class Name
{
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    private $localeResolver;

    private $config;

    /**
     * @param ResolverInterface $localeResolver
     * @param \Magento\Eav\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Magento\Eav\Model\Config $config
    ) {
        $this->localeResolver = $localeResolver;
        $this->config = $config;
    }

    /**
     * @param \Magento\Customer\Model\Customer $subject
     * @param \Closure $proceed
     * @return string
     */
    public function aroundGetName(
        Customer $subject,
        \Closure $proceed
    )
    {
        $name = '';

        if ($this->config->getAttribute('customer', 'prefix')->getIsVisible() && $subject->getPrefix()) {
            $name .= $subject->getPrefix() . ' ';
        }
        if($this->localeResolver->getLocale() != 'ja_JP') {
            $name .= $subject->getFirstname();
        } else {
            $name .= $subject->getLastname();
        }
        if ($this->config->getAttribute('customer', 'middlename')->getIsVisible() && $subject->getMiddlename()) {
            $name .= ' ' . $subject->getMiddlename();
        }
        if($this->localeResolver->getLocale() != 'ja_JP') {
            $name .= ' ' . $subject->getLastname();
        } else {
            $name .= ' ' . $subject->getFirstname();
        }
        if ($this->config->getAttribute('customer', 'suffix')->getIsVisible() && $subject->getSuffix()) {
            $name .= ' ' . $subject->getSuffix();
        }
        return $name;

    }
}
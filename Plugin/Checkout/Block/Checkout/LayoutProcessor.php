<?php
namespace Veriteworks\Localize\Plugin\Checkout\Block\Checkout;

use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Model\Session;

class LayoutProcessor
{
    const CONFIG_ELEMENT_ORDER = 'localize/sort/';
    const CONFIG_COUNTRY_SHOW = 'localize/address/hide_country';
    const CONFIG_REQUIRE_KANA = 'localize/kana/require_kana';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var CustomerRepository
     */
    private $_customerRepository;

    /**
     * @var Session
     */
    private $_customerSession;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterface
     */
    private $_customer;

    /**
     * ModifyPrice constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param Session $customerSession
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        Session $customerSession,
        CustomerRepository $customerRepository
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_customerSession = $customerSession;
        $this->_customerRepository = $customerRepository;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $locale = $this->_scopeConfig->
        getValue('general/locale/code', ScopeInterface::SCOPE_STORE);
        $format = $this->_scopeConfig->
        getValue('localize/address/change_fields_order', ScopeInterface::SCOPE_STORE);

        $hideCountry = $this->_scopeConfig
            ->getValue(self::CONFIG_COUNTRY_SHOW, ScopeInterface::SCOPE_STORE);
        $requireKana  = $this->_scopeConfig
            ->getValue(self::CONFIG_REQUIRE_KANA, ScopeInterface::SCOPE_STORE);

        if($locale == 'ja_JP' && $format) {
            $shippingElements =& $jsLayout['components']['checkout']['children']
            ['steps']['children']['shipping-step']['children']['shippingAddress']
            ['children']['shipping-address-fieldset']['children'];

            foreach($shippingElements as $key => &$shippingelement) {
                if($key == 'region_id')
                {
                    $key = 'region';
                }
                $path = self::CONFIG_ELEMENT_ORDER . $key;
                $config = $this->_scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
                $shippingelement['sortOrder'] = $config;

                if($key == 'country_id' && $hideCountry)
                {
                    $shippingelement['visible'] = false;
                }

                if(in_array($key, ['firstnamekana', 'lastnamekana']))
                {
                    $method = 'get' . ucfirst($key);
                    if($this->_getCustomer()){
                        $shippingelement['value'] = $this->_getCustomer()->$method();
                        if($requireKana) {
                            $shippingelement['validation']['required-entry'] = true;
                        }
                    }
                }
            }

            $payments =& $jsLayout['components']['checkout']['children']
            ['steps']['children']['billing-step']['children']['payment']
            ['children']['payments-list']['children'];

            foreach($payments as &$method) {
                $elements =& $method['children']['form-fields']['children'];
                if(!is_array($elements))
                {
                    continue;
                }
                foreach ($elements as $key => &$billingElement) {
                    if($key == 'region_id')
                    {
                        $key = 'region';
                    }
                    $path = self::CONFIG_ELEMENT_ORDER . $key;
                    $config = $this->_scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
                    $billingElement['sortOrder'] = $config;

                    if($key == 'country_id' && $hideCountry)
                    {
                        $billingElement['visible'] = false;
                    }

                    if(in_array($key, ['firstnamekana', 'lastnamekana']))
                    {
                        $func = 'get' . ucfirst($key);
                        if($this->_getCustomer()) {
                            $billingElement['value'] = $this->_getCustomer()->$func();
                            if ($requireKana) {
                                $billingElement['validation']['required-entry'] = true;
                            }
                        }
                    }
                }
            }

        }
        return $jsLayout;
    }

    /**
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    private function _getCustomer()
    {
        if (!$this->_customer) {
            if ($this->_customerSession->isLoggedIn()) {
                $this->_customer = $this->_customerRepository->getById($this->_customerSession->getCustomerId());
            } else {
                return null;
            }
        }
        return $this->_customer;
    }

}
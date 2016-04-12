<?php
namespace Veriteworks\Localize\Model\Directory\Plugin;

use Magento\Directory\Model\PriceCurrency;

class PriceRound
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * ModifyPrice constructor.
     * @param \Magento\Framework\View\Element\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
    }


    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param \Closure $proceed
     * @param $amount
     * @param null $scope
     * @param null $currency
     * @param int $precision
     * @return mixed
     */
    public function aroundConvertAndRound(PriceCurrency  $subject,
                                \Closure $proceed,
                                $amount,
                                $scope = null,
                                $currency = null,
                                $precision = PriceCurrency::DEFAULT_PRECISION)
    {
        if($subject->getCurrency()->getCode() == 'JPY') {
            /** @var string $method */
            $method = $this->_scopeConfig->getValue('tax/calculation/round');

//            \Magento\Framework\App\ObjectManager::getInstance()
//                ->get('Psr\Log\LoggerInterface')
//                ->debug($method($amount));

            if($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $scope, $currency, $precision);
    }

    /**
     * @param \Magento\Directory\Model\PriceCurrency $subject
     * @param \Closure $proceed
     * @param $amount
     * @param int $precision
     * @return float
     */
    public function aroundRound(PriceCurrency  $subject,
        \Closure $proceed,
        $amount,
        $precision=2)
    {
        //todo: detect currency.
        if($subject->getCurrency()->getCode() == 'JPY') {
            /** @var string $method */
            $method = $this->_scopeConfig->getValue('tax/calculation/round');
            if($method != 'round') {
                return $method($amount);
            }
        }
        return $proceed($amount, $precision);
    }

}
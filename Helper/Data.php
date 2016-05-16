<?php
namespace Veriteworks\Localize\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Veriteworks\Localize\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @param string $store
     * @return mixed
     */
    public function getRoundMethod()
    {
        return $this->scopeConfig->
        getValue('tax/calculation/round', ScopeInterface::SCOPE_STORE);
    }

}

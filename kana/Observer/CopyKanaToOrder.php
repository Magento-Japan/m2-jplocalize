<?php
namespace Veriteworks\Kana\Observer;

use Magento\Framework\Locale\Currency;
use Magento\Framework\Event\ObserverInterface;

class CopyKanaToOrder implements ObserverInterface
{
    /**
     * Assign Kana to destination obj
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $order = $observer->getEvent()->getOrder();

        if($quote->getCustomerIsGuest()) {
            $fKana = $quote->getBillingAddress()->getFirstnamekana();
            $lKana = $quote->getBillingAddress()->getLastnamekana();
        } else {
            $fKana = $quote->getCustomerFirstnamekana();
            $lKana = $quote->getCustomerLastnamekana();
        }


        $order->setCustomerFirstnamekana($fKana);
        $order->setCustomerLastnamekana($lKana);

        return $this;
    }
}

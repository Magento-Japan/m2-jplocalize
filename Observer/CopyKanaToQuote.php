<?php
namespace Veriteworks\Localize\Observer;

use Magento\Framework\Event\ObserverInterface;

class CopyKanaToQuote implements ObserverInterface
{

    /**
     * Assign Kana to destination obj
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $target = $observer->getEvent()->getTarget();
        $source = $observer->getEvent()->getSource();
        $root = $observer->getEvent()->getRoot();
        $customer = $target->getCustomer();

        $fKana = $customer->getFirstnamekana();
        $lKana = $customer->getLastnamekana();

        $target->setCustomerFirstnamekana($fKana);
        $target->setCustomerLastnamekana($lKana);

        return $this;
    }
}

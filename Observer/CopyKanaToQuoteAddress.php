<?php
namespace Veriteworks\Localize\Observer;

use Magento\Framework\Locale\Currency;
use Magento\Framework\Event\ObserverInterface;

class CopyKanaToQuoteAddress implements ObserverInterface
{
    /**
     * Assign Kana to destination obj
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Quote\Model\Quote\Address $target */
        $target = $observer->getEvent()->getTarget();
        $quote  = $target->getQuote();
        $source = $observer->getEvent()->getSource();
        $root = $observer->getEvent()->getRoot();

        $type = $target->getAddressType();
        $address = null;
        $customerAddress = null;
        $id = null;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $address = $objectManager->create('Magento\Customer\Model\Address')
            ->load($target->getCustomerAddressId());

        if($address){
            $fKana = $address->getFirstnamekana();
            $lKana = $address->getLastnamekana();
            $target->setFirstnamekana($fKana);
            $target->setLastnamekana($lKana);
        }


        return $this;
    }
}

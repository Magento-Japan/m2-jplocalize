<?php
namespace Veriteworks\Localize\Plugin\Customer\Model;

use Magento\Customer\Api\Data\CustomerInterface;

class Customer
{
    /**
     * @param \Magento\Customer\Model\Customer $subject
     * @param \Closure $proceed
     * @param \Magento\Customer\Api\Data\AddressInterface $customer
     * @return \Magento\Customer\Model\Customer
     */
    public function aroundUpdateData(\Magento\Customer\Model\Customer $subject,
        \Closure $proceed,
        CustomerInterface $customer
    )
    {
        $subject = $proceed($customer);

        if($customer->getFirstnamekana())
        {
            $subject->setData('firstnamekana', $customer->getFirstnamekana());
        }

        if($customer->getLastnamekana())
        {
            $subject->setData('lastnamekana', $customer->getLastnamekana());
        }

        return $subject;
    }
}
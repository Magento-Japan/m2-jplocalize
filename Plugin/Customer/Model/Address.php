<?php
namespace Veriteworks\Localize\Plugin\Customer\Model;

use Magento\Customer\Api\Data\AddressInterface;

class Address
{
    /**
     * @param \Magento\Customer\Model\Address $subject
     * @param \Closure $proceed
     * @param \Magento\Customer\Api\Data\AddressInterface $address
     * @return \Magento\Customer\Model\Address
     */
    public function aroundUpdateData(\Magento\Customer\Model\Address $subject,
                                    \Closure $proceed,
                                    AddressInterface $address
                                    )
    {
        $subject = $proceed($address);

        if($address->getFirstnamekana())
        {
            $subject->setData('firstnamekana', $address->getFirstnamekana());
        }

        if($address->getLastnamekana())
        {
            $subject->setData('lastnamekana', $address->getLastnamekana());
        }

        return $subject;
    }
}
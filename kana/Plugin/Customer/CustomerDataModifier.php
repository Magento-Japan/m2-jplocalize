<?php
namespace Veriteworks\Kana\Plugin\Customer;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Helper\View;

class CustomerDataModifier
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    private $customerViewHelper;

    /**
     * @param CurrentCustomer $currentCustomer
     * @param View $customerViewHelper
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        View $customerViewHelper
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerViewHelper = $customerViewHelper;
    }



    public function aroundGetSectionData(
        Customer $subject,
        \Closure $proceed
    ) {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }
        $customer = $this->currentCustomer->getCustomer();
        return [
            'fullname' => $this->customerViewHelper->getCustomerName($customer),
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname()
        ];
    }
}
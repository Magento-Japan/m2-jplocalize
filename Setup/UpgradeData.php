<?php
/**
 * Copyright © 2015 Veriteworks Inc. All rights reserved.
 */

namespace Veriteworks\Localize\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Address;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Localize setup factory
     *
     * @var EavSetupFactory
     */
    private $localizeSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $localizeSetupFactory
     */
    public function __construct(EavSetupFactory $localizeSetupFactory)
    {
        $this->localizeSetupFactory = $localizeSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare('1.0.1', $context->getVersion()) < 0) {
            /** @var CustomerSetup $customerSetup */
            $customerSetup = $this->localizeSetupFactory->create(['setup' => $setup]);

            $setup->startSetup();

            $attributes = [
                'firstnamekana' =>
                    [
                        'type' => 'varchar',
                        'input' => 'text',
                        'visible' => true,
                        'required' => false,
                        'system' => 0,
                        'sort_order' => 45,
                        'validate_rules' => 'a:2:{s:15:"max_text_length";i:255;s:15:"min_text_length";i:1;}',
                        'position' => 45,
                        'label' => 'First name kana',
                    ],
                'lastnamekana' =>
                    [
                        'type' => 'varchar',
                        'input' => 'text',
                        'visible' => true,
                        'required' => false,
                        'system' => 0,
                        'sort_order' => 65,
                        'validate_rules' => 'a:2:{s:15:"max_text_length";i:255;s:15:"min_text_length";i:1;}',
                        'position' => 65,
                        'label' => 'Last name kana',
                    ]
            ];

            foreach ($attributes as $code => $options) {
                $customerSetup->addAttribute(
                    Customer::ENTITY,
                    $code,
                    $options
                );

                $customerSetup->addAttribute(
                    'customer_address',
                    $code,
                    $options
                );
            }

            $this->installCustomerForms($customerSetup, $attributes);


            $setup->endSetup();
        }

    }

    /**
     * Add customer attributes to customer forms
     *
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function installCustomerForms(EavSetup $eavSetup, array $attributes)
    {
        $customer = (int)$eavSetup->getEntityTypeId('customer');
        $customerAddress = (int)$eavSetup->getEntityTypeId('customer_address');
        /**
         * @var ModuleDataSetupInterface $setup
         */
        $setup = $eavSetup->getSetup();

        $attributeIds = [];
        $select = $setup->getConnection()->select()->from(
            ['ea' => $setup->getTable('eav_attribute')],
            ['entity_type_id', 'attribute_code', 'attribute_id']
        )->where(
            'ea.entity_type_id IN(?)',
            [$customer, $customerAddress]
        );
        foreach ($setup->getConnection()->fetchAll($select) as $row) {
            if(preg_match('/kana/', $row['attribute_code'])) {
                $attributeIds[$row['entity_type_id']][$row['attribute_code']] = $row['attribute_id'];
            }
        }

        $data = [];

        foreach ($attributes as $attributeCode => $attribute) {
            $attributeId = $attributeIds[$customer][$attributeCode];
            $attribute['system'] = isset($attribute['system']) ? $attribute['system'] : true;
            $attribute['visible'] = isset($attribute['visible']) ? $attribute['visible'] : true;
            if ($attribute['system'] != true || $attribute['visible'] != false) {
                $usedInForms = ['customer_account_create', 'customer_account_edit', 'checkout_register'];
                if (!empty($attribute['adminhtml_only'])) {
                    $usedInForms = ['adminhtml_customer'];
                } else {
                    $usedInForms[] = 'adminhtml_customer';
                }
                if (!empty($attribute['admin_checkout'])) {
                    $usedInForms[] = 'adminhtml_checkout';
                }
                foreach ($usedInForms as $formCode) {
                    $data[] = ['form_code' => $formCode, 'attribute_id' => $attributeId];
                }
            }
        }


        if ($data) {
            $setup->getConnection()
                ->insertMultiple($setup->getTable('customer_form_attribute'), $data);
        }
    }
}

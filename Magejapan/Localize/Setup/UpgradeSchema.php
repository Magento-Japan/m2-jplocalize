<?php
/**
 * Copyright © 2015 Magejapan Inc. All rights reserved.
 */

namespace Magejapan\Localize\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0.3') < 0) {

            $installer = $setup;

            /**
             * update columns created_at and updated_at in sales entities tables
             */

            $tables = ['sales_order',
                'sales_order_address'
            ];
            /** @var \Magento\Framework\DB\Adapter\AdapterInterface $connection */
            $connection = $installer->getConnection();
            foreach ($tables as $table) {
                $columns = $connection->describeTable($installer->getTable($table));
                if (!isset($columns['customer_lastnamekana'])) {
                    $setup->getConnection()
                        ->addColumn(
                            $table,
                        'customer_lastnamekana',
                        [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'Customer Lastname Kana']);
                }
                if (!isset($columns['customer_firstnamekana'])) {
                    $setup->getConnection()
                        ->addColumn(
                            $table,
                        'customer_firstnamekana',
                        [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'Customer Firstname Kana']);
                }
            }

        }

    }
}

<?php
/**
 * Copyright © 2015 Veriteworks Inc. All rights reserved.
 */

namespace Veriteworks\Localize\Setup;

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
        echo $context->getVersion();
        if (version_compare('1.0.1', $context->getVersion()) < 0) {

            $installer = $setup;

            /**
             * update columns created_at and updated_at in sales entities tables
             */

            $tables = ['sales_order',
                'quote',
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

            $tables = [
                'sales_order_address',
                'quote_address'
            ];
            foreach ($tables as $table) {
                $columns = $connection->describeTable($installer->getTable($table));
                if (!isset($columns['lastnamekana'])) {
                    $setup->getConnection()
                        ->addColumn(
                            $table,
                            'lastnamekana',
                            [
                                'type' => Table::TYPE_TEXT,
                                'length' => 255,
                                'comment' => 'Customer Lastname Kana']);
                }
                if (!isset($columns['firstnamekana'])) {
                    $setup->getConnection()
                        ->addColumn(
                            $table,
                            'firstnamekana',
                            [
                                'type' => Table::TYPE_TEXT,
                                'length' => 255,
                                'comment' => 'Customer Firstname Kana']);
                }
            }

        }
    }
}

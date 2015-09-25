<?php
/**
 * Copyright © 2015 Magejapan Inc. All rights reserved.
 */

namespace Magejapan\Localize\Setup;

use Magento\Directory\Helper\Data;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Directory data
     *
     * @var Data
     */
    private $directoryData;

    /**
     * Init
     *
     * @param Data $directoryData
     */
    public function __construct(Data $directoryData)
    {
        $this->directoryData = $directoryData;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Fill table directory/country_region
         * Fill table directory/country_region_name for en_US locale
         */
        $data = [
            ['JP', 'Hokkaido', 'Hokkaido', '北海道'],
            ['JP', 'Aomori', 'Aomori', '青森県'],
            ['JP', 'Iwate', 'Iwate', '岩手県'],
            ['JP', 'Miyagi', 'Miyagi', '宮城県'],
            ['JP', 'Akita', 'Akita', '秋田県'],
            ['JP', 'Yamagata', 'Yamagata', '山形県'],
            ['JP', 'Fukushima', 'Fukushima', '福島県'],
            ['JP', 'Ibaraki', 'Ibaraki', '茨城県'],
            ['JP', 'Tochigi', 'Tochigi', '栃木県'],
            ['JP', 'Gunma', 'Gunma', '群馬県'],
            ['JP', 'Saitama', 'Saitama', '埼玉県'],
            ['JP', 'Chiba', 'Chiba', '千葉県'],
            ['JP', 'Tokyo', 'Tokyo', '東京都'],
            ['JP', 'Kanagawa', 'Kanagawa', '神奈川県'],
            ['JP', 'Niigata', 'Niigata', '新潟県'],
            ['JP', 'Toyama', 'Toyama', '富山県'],
            ['JP', 'Ishikawa', 'Ishikawa', '石川県'],
            ['JP', 'Fukui', 'Fukui', '福井県'],
            ['JP', 'Yamanashi', 'Yamanashi', '山梨県'],
            ['JP', 'Nagano', 'Nagano', '長野県'],
            ['JP', 'Gifu', 'Gifu', '岐阜県'],
            ['JP', 'Shizuoka', 'Shizuoka', '静岡県'],
            ['JP', 'Aichi', 'Aichi', '愛知県'],
            ['JP', 'Mie', 'Mie', '三重県'],
            ['JP', 'Shiga', 'Shiga', '滋賀県'],
            ['JP', 'Kyoto', 'Kyoto', '京都府'],
            ['JP', 'Osaka', 'Osaka', '大阪府'],
            ['JP', 'Hyogo', 'Hyogo', '兵庫県'],
            ['JP', 'Nara', 'Nara', '奈良県'],
            ['JP', 'Wakayama', 'Wakayama', '和歌山県'],
            ['JP', 'Tottori', 'Tottori', '鳥取県'],
            ['JP', 'Shimane', 'Shimane', '島根県'],
            ['JP', 'Okayama', 'Okayama', '岡山県'],
            ['JP', 'Hiroshima', 'Hiroshima', '広島県'],
            ['JP', 'Yamaguchi', 'Yamaguchi', '山口県'],
            ['JP', 'Tokushima', 'Tokushima', '徳島県'],
            ['JP', 'Kagawa', 'Kagawa', '香川県'],
            ['JP', 'Ehime', 'Ehime', '愛媛県'],
            ['JP', 'Kochi', 'Kochi', '高知県'],
            ['JP', 'Fukuoka', 'Fukuoka', '福岡県'],
            ['JP', 'Saga', 'Saga', '佐賀県'],
            ['JP', 'Nagasaki', 'Nagasaki', '長崎県'],
            ['JP', 'Kumamoto', 'Kumamoto', '熊本県'],
            ['JP', 'Oita', 'Oita', '大分県'],
            ['JP', 'Miyazaki', 'Miyazaki', '宮崎県'],
            ['JP', 'Kagoshima', 'Kagoshima', '鹿児島県'],
            ['JP', 'Okinawa', 'Okinawa', '沖縄県']
        ];

        foreach ($data as $row) {
            $bind = ['country_id' => $row[0], 'code' => $row[1], 'default_name' => $row[2]];
            $setup->getConnection()->insert($setup->getTable('directory_country_region'), $bind);
            $regionId = $setup->getConnection()->lastInsertId($setup->getTable('directory_country_region'));

            $bind = ['locale' => 'en_US', 'region_id' => $regionId, 'name' => $row[2]];
            $setup->getConnection()->insert($setup->getTable('directory_country_region_name'), $bind);

            $bind = ['locale' => 'ja_JP', 'region_id' => $regionId, 'name' => $row[3]];
            $setup->getConnection()->insert($setup->getTable('directory_country_region_name'), $bind);
        }
    }
}

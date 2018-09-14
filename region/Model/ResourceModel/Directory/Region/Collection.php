<?php
/**
 * Region Colleciton
 *
 * PHP version 5, 7
 *
 * @category Test
 * @package  Veriteworks\Region\Model\ResourceModel\Directory\Region
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Region\Model\ResourceModel\Directory\Region;

use \Magento\Framework\Data\Collection as DataCollection;

/**
 * Class Collection
 *
 * @category Test
 * @package  Veriteworks\Region\Model\ResourceModel\Directory\Region
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class Collection extends \Magento\Directory\Model\ResourceModel\Region\Collection
{
    /**
     * Define main, country, locale region name tables
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Magento\Directory\Model\Region',
            'Magento\Directory\Model\ResourceModel\Region'
        );

        $this->_countryTable = $this->getTable('directory_country');
        $this->_regionNameTable = $this->getTable('directory_country_region_name');

        $this->addOrder('region_id', DataCollection::SORT_ORDER_ASC);
    }

}


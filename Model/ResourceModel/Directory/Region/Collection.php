<?php
namespace Veriteworks\Localize\Model\ResourceModel\Directory\Region;


/**
 * Class Collection
 * @package Veriteworks\Localize\Model\ResourceModel\Directory\Region
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
        $this->_init('Magento\Directory\Model\Region',
                     'Magento\Directory\Model\ResourceModel\Region');

        $this->_countryTable = $this->getTable('directory_country');
        $this->_regionNameTable = $this->getTable('directory_country_region_name');

        if($this->_localeResolver->getLocale() != 'ja_JP') {
            $this->addOrder('name', \Magento\Framework\Data\Collection::SORT_ORDER_ASC);
            $this->addOrder('default_name', \Magento\Framework\Data\Collection::SORT_ORDER_ASC);
        }
    }

    /**
     * Convert collection items to select options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if($this->_localeResolver->getLocale() != 'ja_JP') {
            $options = $this->_toOptionArray(
                'region_id',
                'default_name',
                ['title' => 'default_name', 'country_id' => 'country_id']
            );
        } else {
            $options = $this->_toOptionArray(
                'region_id',
                'name',
                ['title' => 'name', 'country_id' => 'country_id']
            );
        }
        if (count($options) > 0) {
            array_unshift($options,
                ['title ' => null,
                 'value' => null,
                 'label' => __('--Please select--')
                ]);
        }
        return $options;
    }
}


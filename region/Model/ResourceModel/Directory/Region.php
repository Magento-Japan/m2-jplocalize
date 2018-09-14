<?php
namespace Veriteworks\Region\Model\ResourceModel\Directory;

use \Magento\Directory\Model\ResourceModel\Region as Base;

class Region extends Base
{
    /**
     * Load data by country id and default region name
     *
     * @param \Magento\Directory\Model\Region $region
     * @param string $regionName
     * @param string $countryId
     * @return $this
     */
    public function loadByLocalName(\Magento\Directory\Model\Region $region, $regionName, $countryId)
    {
        $connection = $this->getConnection();
        $locale = $this->_localeResolver->getLocale();
        $joinCondition = $connection->quoteInto('rname.region_id = region.region_id AND rname.locale = ?', $locale);
        $select = $connection->select()->from(
            ['region' => $this->getMainTable()]
        )->joinLeft(
            ['rname' => $this->_regionNameTable],
            $joinCondition,
            ['name']
        )->where(
            'region.country_id = ?',
            $countryId
        )->where(
            "rname.name = ?",
            $regionName
        );

        $data = $connection->fetchRow($select);
        if ($data) {
            $region->setData($data);
        }

        $this->_afterLoad($region);

        return $this;
    }
}
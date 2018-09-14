<?php
namespace Veriteworks\Region\Model;

use \Magento\Directory\Model\Region as Base;


class Region extends Base
{
    /**
     * Load region by name
     *
     * @param string $name
     * @param string $countryId
     * @return $this
     */
    public function loadByLocalName($name, $countryId)
    {
        $this->_getResource()->loadByLocalName($this, $name, $countryId);
        return $this;
    }
}
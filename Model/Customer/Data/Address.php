<?php
namespace Veriteworks\Localize\Model\Customer\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class Address extends \Magento\Customer\Model\Data\Address
{
    const FIRSTNAMEKANA = 'firstnamekana';
    const LASTNAMEKANA = 'lastnamekana';

    /**
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $attributeValueFactory
     * @param \Magento\Customer\Api\AddressMetadataInterface $metadataService
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        \Magento\Customer\Api\AddressMetadataInterface $metadataService,
        $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $metadataService, $data);
    }

    /**
     * Set first name kana
     *
     * @param string $firstnamekana
     * @return $this
     */
    public function setFirstnamekana($firstnamekana)
    {
        return $this->setData(self::FIRSTNAMEKANA, $firstnamekana);
    }

    /**
     * Set last name kana
     *
     * @param string $lastnamekana
     * @return string
     */
    public function setLastnamekana($lastnamekana)
    {
        return $this->setData(self::LASTNAMEKANA, $lastnamekana);
    }

    /**
     * Get first name kana
     *
     * @return string
     */
    public function getFirstnamekana()
    {
        return $this->_get(self::FIRSTNAMEKANA);
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastnamekana()
    {
        return $this->_get(self::LASTNAMEKANA);
    }
}
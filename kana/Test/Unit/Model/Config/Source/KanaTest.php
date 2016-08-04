<?php
namespace Veriteworks\Kana\Test\Unit\Model\Config\Source;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;


/**
 * Class KanaTest
 * @package Veriteworks\Kana\Test\Unit\Model\Config\Source
 */
class KanaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Veriteworks\Kana\Model\Config\Source\Kana
     */
    protected $_model;

    /**
     *
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->_model =
            $objectManager->getObject('Veriteworks\Kana\Model\Config\Source\Kana');
    }

    /**
     *
     */
    public function testToOptionArray()
    {
        $this->assertArrayHasKey('1', $this->_model->toOptionArray());
    }
}
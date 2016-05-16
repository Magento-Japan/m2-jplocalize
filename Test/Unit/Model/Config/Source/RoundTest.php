<?php
namespace Veriteworks\Localize\Test\Unit\Model\Config\Source;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;


/**
 * Class RoundTest
 * @package Veriteworks\Localize\Test\Unit\Model\Config\Source
 */
class RoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Veriteworks\Localize\Model\Config\Source\Round
     */
    protected $_model;

    /**
     *
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->_model =
            $objectManager->getObject('Veriteworks\Localize\Model\Config\Source\Round');
    }

    /**
     *
     */
    public function testToOptionArray()
    {
        $this->assertArrayHasKey('round', $this->_model->toOptionArray());
    }
}
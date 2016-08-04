<?php
namespace Veriteworks\Price\Test\Unit\Model\Directory\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PrecisionTest extends \PHPUnit_Framework_TestCase
{
    protected $_precisionPlugin;

    protected $_closure;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->_precisionPlugin =
            $objectManager->getObject('Veriteworks\Price\Model\Directory\Plugin\Precision');

        $this->_closure = function () {
            return '<span class="price">￥100</span>';
        };
    }

    public function testJpyAroundFormatPrecision()
    {
        $currency = $this->getMock('Magento\Directory\Model\Currency', [], [], '', false);
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->assertEquals('<span class="price">￥100</span>',
            $this->_precisionPlugin
                 ->aroundFormatPrecision($currency,
                                         $this->_closure,
                                         100.49,
                                         [],
                                         true,
                                         false));
    }

    public function testNonJpyAroundFormatPrecision()
    {
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('USD');

        $this->assertNotEquals('<span class="price">￥100.49</span>',
            $this->_precisionPlugin
                 ->aroundFormatPrecision($currency,
                                         $this->_closure,
                                         100.49,
                                         [],
                                         true,
                                         false));
    }
}
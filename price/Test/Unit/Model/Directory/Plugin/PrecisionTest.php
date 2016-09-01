<?php
namespace Veriteworks\Price\Test\Unit\Model\Directory\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PrecisionTest extends \PHPUnit_Framework_TestCase
{
    protected $precisionPlugin;

    protected $closure;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->precisionPlugin =
            $objectManager->getObject('Veriteworks\Price\Model\Directory\Plugin\Precision');

        $this->closure = function () {
            return '<span class="price">￥100</span>';
        };
    }

    public function testJpyAroundFormatPrecision()
    {
        $currency = $this->getMock('Magento\Directory\Model\Currency', [], [], '', false);
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->assertEquals('<span class="price">￥100</span>',
            $this->precisionPlugin
                 ->aroundFormatPrecision($currency,
                                         $this->closure,
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
            $this->precisionPlugin
                 ->aroundFormatPrecision($currency,
                                         $this->closure,
                                         100.49,
                                         [],
                                         true,
                                         false));
    }
}
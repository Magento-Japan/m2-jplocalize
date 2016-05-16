<?php
namespace Veriteworks\Localize\Test\Unit\Model\Directory\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class FormatTest extends \PHPUnit_Framework_TestCase
{
    protected $_formatPlugin;

    protected $_priceCurrency;

    protected $_closure;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->_formatPlugin =
            $objectManager->getObject('Veriteworks\Localize\Model\Directory\Plugin\Format');

        $this->_priceCurrency =
            $this->getMockBuilder('Magento\Directory\Model\PriceCurrency')
            ->disableOriginalConstructor()
            ->getMock();

        $this->_closure = function () {
            return '<span class="price">￥100.49</span>';
        };
    }

    public function testJpyAroundFormat()
    {
        $currency = $this->getMock('Magento\Directory\Model\Currency', [], [], '', false);
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');
        $currency->expects($this->atLeastOnce())
            ->method('formatPrecision')->willReturn('<span class="price">￥100</span>');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals('<span class="price">￥100</span>', $this->_formatPlugin->aroundFormat($this->_priceCurrency, $this->_closure, 100.49, 2, null, null));
    }

    public function testNonJpyAroundFormat()
    {
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('USD');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertNotEquals('<span class="price">￥100</span>', $this->_formatPlugin->aroundFormat($this->_priceCurrency, $this->_closure, 100.49, 2, null, null));
    }
}
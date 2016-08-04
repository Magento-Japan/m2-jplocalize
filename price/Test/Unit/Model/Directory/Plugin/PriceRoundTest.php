<?php
namespace Veriteworks\Price\Test\Unit\Model\Directory\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PriceRoundTest extends \PHPUnit_Framework_TestCase
{
    protected $_priceRoundPlugin;

    protected $_priceCurrency;

    protected $_helper;

    protected $_closure;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->_helper =
            $this->getMockBuilder('Veriteworks\Price\Helper\Data')
                ->disableOriginalConstructor()
                ->getMock();

        $this->_priceRoundPlugin =
            $objectManager->getObject('Veriteworks\Price\Model\Directory\Plugin\PriceRound',
                ['helper' => $this->_helper]);

        $this->_priceCurrency =
            $this->getMockBuilder('Magento\Directory\Model\PriceCurrency')
                ->disableOriginalConstructor()
                ->getMock();

        $this->_closure = function () {
            return 100;
        };
    }

    public function testAroundConvertRoundRound()
    {
        $this->_helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('round');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->_priceRoundPlugin
                 ->aroundConvertAndRound($this->_priceCurrency,
                                         $this->_closure,
                                         100.49,
                                         [],
                                         null,
                                         'JPY',
                                         2));
    }

    public function testAroundConvertRoundCeil()
    {
        $this->_helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('ceil');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(101,
            $this->_priceRoundPlugin
                ->aroundConvertAndRound($this->_priceCurrency,
                    $this->_closure,
                    100.49,
                    [],
                    null,
                    'JPY',
                    2));
    }

    public function testAroundConvertRoundFloor()
    {
        $this->_helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('floor');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->_priceRoundPlugin
                ->aroundConvertAndRound($this->_priceCurrency,
                    $this->_closure,
                    100.49,
                    [],
                    null,
                    'JPY',
                    2));
    }

    public function testAroundRoundRound()
    {
        $this->_helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('round');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->_priceRoundPlugin
                 ->aroundRound($this->_priceCurrency,
                                         $this->_closure,
                                         100.49,
                                         'USD',
                                         2));
    }

    public function testAroundRoundCeil()
    {
        $this->_helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('ceil');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(101,
            $this->_priceRoundPlugin
                ->aroundRound($this->_priceCurrency,
                    $this->_closure,
                    100.49,
                    'USD',
                    2));
    }

    public function testAroundRoundFloor()
    {
        $this->_helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('floor');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->_priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->_priceRoundPlugin
                ->aroundRound($this->_priceCurrency,
                    $this->_closure,
                    100.49,
                    'USD',
                    2));
    }
}
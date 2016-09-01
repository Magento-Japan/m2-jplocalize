<?php
namespace Veriteworks\Price\Test\Unit\Model\Directory\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class PriceRoundTest extends \PHPUnit_Framework_TestCase
{
    protected $priceRoundPlugin;

    protected $priceCurrency;

    protected $helper;

    protected $closure;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->helper =
            $this->getMockBuilder('Veriteworks\Price\Helper\Data')
                ->disableOriginalConstructor()
                ->getMock();

        $this->priceRoundPlugin =
            $objectManager->getObject('Veriteworks\Price\Model\Directory\Plugin\PriceRound',
                ['helper' => $this->helper]);

        $this->priceCurrency =
            $this->getMockBuilder('Magento\Directory\Model\PriceCurrency')
                ->disableOriginalConstructor()
                ->getMock();

        $this->closure = function () {
            return 100;
        };
    }

    public function testAroundConvertRoundRound()
    {
        $this->helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('round');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->priceRoundPlugin
                 ->aroundConvertAndRound($this->priceCurrency,
                                         $this->closure,
                                         100.49,
                                         [],
                                         null,
                                         'JPY',
                                         2));
    }

    public function testAroundConvertRoundCeil()
    {
        $this->helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('ceil');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(101,
            $this->priceRoundPlugin
                ->aroundConvertAndRound($this->priceCurrency,
                    $this->closure,
                    100.49,
                    [],
                    null,
                    'JPY',
                    2));
    }

    public function testAroundConvertRoundFloor()
    {
        $this->helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('floor');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->priceRoundPlugin
                ->aroundConvertAndRound($this->priceCurrency,
                    $this->closure,
                    100.49,
                    [],
                    null,
                    'JPY',
                    2));
    }

    public function testAroundRoundRound()
    {
        $this->helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('round');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->priceRoundPlugin
                 ->aroundRound($this->priceCurrency,
                                         $this->closure,
                                         100.49,
                                         'USD',
                                         2));
    }

    public function testAroundRoundCeil()
    {
        $this->helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('ceil');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(101,
            $this->priceRoundPlugin
                ->aroundRound($this->priceCurrency,
                    $this->closure,
                    100.49,
                    'USD',
                    2));
    }

    public function testAroundRoundFloor()
    {
        $this->helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('floor');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $this->priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(100,
            $this->priceRoundPlugin
                ->aroundRound($this->priceCurrency,
                    $this->closure,
                    100.49,
                    'USD',
                    2));
    }
}
<?php
/**
 * Price Round Plugin Test
 *
 * PHP version 5, 7
 *
 * @category Test
 * @package  Veriteworks\Price\Test\Unit\Model\Directory\Plugin
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Test\Unit\Model\Directory\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use \Magento\Directory\Model\PriceCurrency;
use \Veriteworks\Price\Helper\Data;
use \Veriteworks\Price\Model\Directory\Plugin\PriceRound;

/**
 * Class PriceRoundTest
 *
 * @category Test
 * @package  Veriteworks\Price\Test\Unit\Model\Directory\Plugin
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class PriceRoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Price Round Plugin
     *
     * @var PriceRound
     */
    protected $priceRoundPlugin;

    /**
     * Price Currency
     *
     * @var PriceCurrency|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priceCurrency;

    /**
     * Helper
     *
     * @var Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $helper;

    /**
     * Closure for enclose price
     *
     * @var \Closure
     */
    protected $closure;

    /**
     * Setup
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->helper = $this->getMockBuilder('Veriteworks\Price\Helper\Data')
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceRoundPlugin = $objectManager->getObject(
            'Veriteworks\Price\Model\Directory\Plugin\PriceRound',
            ['helper' => $this->helper]
        );

        $this->priceCurrency = $this->getMockBuilder(
            'Magento\Directory\Model\PriceCurrency'
        )->disableOriginalConstructor()->getMock();

        $this->closure = function () {
            return 100;
        };
    }

    /**
     * Test for aroundConverterRound (round)
     *
     * @return void
     */
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

        $this->assertEquals(
            100,
            $this->priceRoundPlugin->aroundConvertAndRound(
                $this->priceCurrency,
                $this->closure,
                100.49,
                [],
                null,
                'JPY',
                2
            )
        );
    }

    /**
     * Test for aroundConverterRound (ceil)
     *
     * @return void
     */
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

        $this->assertEquals(
            101,
            $this->priceRoundPlugin->aroundConvertAndRound(
                $this->priceCurrency,
                $this->closure,
                100.49,
                [],
                null,
                'JPY',
                2
            )
        );
    }

    /**
     * Test for aroundConverterRound (floor)
     *
     * @return void
     */
    public function testAroundConvertRoundFloor()
    {
        $helper = $this->helper;
        $priceCurrency = $this->priceCurrency;
        $priceRound = $this->priceRoundPlugin;
        $closure = $this->closure;
        $helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('floor');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(
            100,
            $priceRound->aroundConvertAndRound(
                $priceCurrency,
                $closure,
                100.49,
                [],
                null,
                'JPY',
                2
            )
        );
    }

    /**
     * Test for aroundRoundRound (round)
     *
     * @return void
     */
    public function testAroundRoundRound()
    {
        $helper = $this->helper;
        $priceCurrency = $this->priceCurrency;
        $priceRound = $this->priceRoundPlugin;
        $closure = $this->closure;
        $helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('round');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(
            100,
            $priceRound->aroundRound($priceCurrency, $closure, 100.49, 'USD', 2)
        );
    }

    /**
     * Test for aroundRoundRound (ceil)
     *
     * @return void
     */
    public function testAroundRoundCeil()
    {
        $helper = $this->helper;
        $priceCurrency = $this->priceCurrency;
        $priceRound = $this->priceRoundPlugin;
        $closure = $this->closure;
        $helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('ceil');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(
            101,
            $priceRound->aroundRound($priceCurrency, $closure, 100.49, 'USD', 2)
        );
    }

    /**
     * Test for aroundRoundRound (floor)
     *
     * @return void
     */
    public function testAroundRoundFloor()
    {
        $helper = $this->helper;
        $priceCurrency = $this->priceCurrency;
        $priceRound = $this->priceRoundPlugin;
        $closure = $this->closure;

        $helper->expects($this->atLeastOnce())
            ->method('getRoundMethod')
            ->willReturn('floor');
        $currency = $this->getMockBuilder('Magento\Directory\Model\Currency')
            ->disableOriginalConstructor()
            ->getMock();
        $currency->expects($this->atLeastOnce())
            ->method('getCode')->willReturn('JPY');

        $priceCurrency->expects($this->atLeastOnce())
            ->method('getCurrency')->willReturn($currency);

        $this->assertEquals(
            100,
            $priceRound->aroundRound($priceCurrency, $closure, 100.49, 'USD', 2)
        );
    }
}
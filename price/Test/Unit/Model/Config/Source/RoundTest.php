<?php
/**
 * Price Round Config Class Test
 *
 * PHP version 5, 7
 *
 * @category Test
 * @package  Veriteworks\Price\Test\Unit\Model\Config\Source
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
namespace Veriteworks\Price\Test\Unit\Model\Config\Source;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Class RoundTest
 *
 * @category Test
 * @package  Veriteworks\Price\Test\Unit\Model\Config\Source
 * @author   Veriteworks Inc. <info@veriteworks.co.jp>
 * @license  Open Software License 3.0
 * @link     https://principle-works.jp/
 */
class RoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Round configuration class
     *
     * @var \Veriteworks\Price\Model\Config\Source\Round
     */
    protected $model;

    /**
     * Setup
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->model = $objectManager->getObject(
            'Veriteworks\Price\Model\Config\Source\Round'
        );
    }

    /**
     * Test toOptionArray
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $this->assertArrayHasKey('round', $this->model->toOptionArray());
    }
}
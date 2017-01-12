<?php
namespace Veriteworks\Kana\Test\Unit\Model\Config\Source;
use Veriteworks\Kana\Model\Config\Source\Kana;


/**
 * Class KanaTest
 * @package Veriteworks\Kana\Test\Unit\Model\Config\Source
 */
class KanaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Veriteworks\Kana\Model\Config\Source\Kana
     */
    protected $model;

    /**
     *
     */
    protected function setUp()
    {
        $this->model = new Kana();
    }

    /**
     *
     */
    public function testToOptionArray()
    {
        $this->assertArrayHasKey('1', $this->model->toOptionArray());
    }
}
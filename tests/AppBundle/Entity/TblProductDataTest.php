<?php

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\TblProductData;
use PHPUnit\Framework\TestCase;

/**
 * Class TblProductDataTest
 * @package Tests\AppBundle\Entity
 */
class TblProductDataTest extends TestCase
{
    /**
     * @var array $validData
     */
    private $validData = [
        'Product Code' => 'P0001',
        'Product Name' => 'TV',
        'Product Description' => '32" TV',
        'Stock' => '10',
        'Cost in GBP' => '399.99',
        'Discontinued' => 'yes'
    ];

    /**
     * @var array $invalidData
     */
    private $invalidData = [
        'Product Code' => 'P0002',
    ];

    /**
     * @var TblProductData|null $productData
     */
    private $productData;

    /**
     * Provides a mock object
     */
    protected function setUp()
    {
        $this->productData = TblProductData::loadFields($this->validData);
    }

    public function testLoad()
    {
        $this->assertInstanceOf(TblProductData::class, $this->productData);
    }

    public function testCheckProductData()
    {
        $this->assertEquals(true, $this->productData->checkProductData());
    }
}

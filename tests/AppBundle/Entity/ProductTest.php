<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Product;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductTest
 * @package Tests\AppBundle\Entity
 */
class ProductTest extends TestCase
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
     * @var Product|null $productData
     */
    private $productData;

    /**
     * Provides a mock object
     */
    protected function setUp()
    {
        $this->productData = new Product($this->validData);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(Product::class, $this->productData);
    }
}

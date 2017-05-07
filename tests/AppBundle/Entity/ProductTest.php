<?php

declare(strict_types=1);

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Product;
use Money\Money;

final class ProductTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_title(): void
    {
        $product = new Product();
        $product->setTitle('Fallout');

        $this->assertEquals('Fallout', $product->getTitle());
    }

    /**
     * @test
     */
    public function it_has_price(): void
    {
        $product = new Product();
        $product->setPrice(Money::USD(199));

        $this->assertEquals(Money::USD(199), $product->getPrice());
    }

    /**
     * @test
     */
    public function it_has_not_title_by_default(): void
    {
        $product = new Product();
        $this->assertEquals(null, $product->getTitle());
    }

    /**
     * @test
     */
    public function it_has_not_price_by_default(): void
    {
        $product = new Product();
        $this->assertEquals(null, $product->getPrice());
    }

    /**
     * @test
     */
    public function it_has_not_id_by_default(): void
    {
        $product = new Product();
        $this->assertEquals(null, $product->getId());
    }
}

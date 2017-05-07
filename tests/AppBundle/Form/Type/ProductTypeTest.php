<?php

declare(strict_types=1);

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\Product;
use AppBundle\Form\Type\ProductType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Tbbc\MoneyBundle\Form\Type\CurrencyType;
use Tbbc\MoneyBundle\Form\Type\MoneyType;

final class ProductTypeTest extends TypeTestCase
{
    /**
     * @return array
     */
    protected function getExtensions(): array
    {
        $productType = new ProductType();
        $moneyType = new MoneyType(2);
        $currencyType = new CurrencyType(['USD'], 'USD');

        return [
            new PreloadedExtension([$productType, $moneyType, $currencyType], []),
        ];
    }

    /**
     * @test
     */
    public function it_returns_product_from_submitted_data(): void
    {
        $product = new Product();

        $form = $this->factory->create(ProductType::class, $product);

        $form->submit([
            'title' => 'Fallout',
            'price' => [
                'tbbc_amount' => '1.99',
                'tbbc_currency' => ['tbbc_name' => 'USD']
            ],
        ]);

        $this->assertEquals('Fallout', $product->getTitle());
        $this->assertEquals('199', $product->getPrice()->getAmount());
        $this->assertEquals('USD', $product->getPrice()->getCurrency());
    }
}

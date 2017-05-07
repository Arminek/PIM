<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Money\Money;

final class Product implements ProductInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Money
     */
    private $price;

    /**
     * @return mixed
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle():? string
    {
        return $this->title;
    }

    /**
     * @return Money
     */
    public function getPrice():? Money
    {
        return $this->price;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param Money $price
     */
    public function setPrice(Money $price)
    {
        $this->price = $price;
    }
}

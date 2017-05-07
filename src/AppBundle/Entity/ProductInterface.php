<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Money\Money;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductInterface extends ResourceInterface
{
    /**
     * @return string|null
     */
    public function getTitle():? string;

    /**
     * @return Money|null
     */
    public function getPrice():? Money;

    /**
     * @param string $title
     */
    public function setTitle(string $title);

    /**
     * @param Money $price
     */
    public function setPrice(Money $price);
}

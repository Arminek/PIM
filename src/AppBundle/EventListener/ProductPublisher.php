<?php

declare(strict_types=1);

namespace AppBundle\EventListener;

use AppBundle\Entity\ProductInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Serializer\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

final class ProductPublisher
{
    const PRODUCT_CREATED_MESSAGE_TYPE = 'ProductCreated';
    const PRODUCT_UPDATED_MESSAGE_TYPE = 'ProductUpdated';
    const PRODUCT_DELETED_MESSAGE_TYPE = 'ProductDeleted';

    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param ProducerInterface $producer
     * @param Serializer $serializer
     */
    public function __construct(ProducerInterface $producer, Serializer $serializer)
    {
        $this->producer = $producer;
        $this->serializer = $serializer;
    }

    /**
     * @param ResourceControllerEvent $event
     */
    public function publishProductCreated(ResourceControllerEvent $event): void
    {
        $this->producer->publish($this->createJsonMessage($event->getSubject(), self::PRODUCT_CREATED_MESSAGE_TYPE));
    }

    /**
     * @param ResourceControllerEvent $event
     */
    public function publishProductUpdated(ResourceControllerEvent $event): void
    {
        $this->producer->publish($this->createJsonMessage($event->getSubject(), self::PRODUCT_UPDATED_MESSAGE_TYPE));
    }

    /**
     * @param ResourceControllerEvent $event
     */
    public function publishProductDeleted(ResourceControllerEvent $event): void
    {
        $this->producer->publish($this->createJsonMessage($event->getSubject(), self::PRODUCT_DELETED_MESSAGE_TYPE));
    }

    /**
     * @param ProductInterface $product
     * @param string $messageType
     *
     * @return string
     */
    private function createJsonMessage(ProductInterface $product, string $messageType): string
    {
        $recordedOn = new \DateTimeImmutable();
        $message = [
            'type' => $messageType,
            'payload' => $product,
            'recordedOn' => $recordedOn->format('Y-m-d H:i:s'),
        ];

        return $this->serializer->serialize($message, 'json', new Context());
    }
}

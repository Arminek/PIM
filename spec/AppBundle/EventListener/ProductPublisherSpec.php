<?php

declare(strict_types=1);

namespace spec\AppBundle\EventListener;

use AppBundle\Entity\ProductInterface;
use AppBundle\EventListener\ProductPublisher;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Serializer\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

final class ProductPublisherSpec extends ObjectBehavior
{
    function let(ProducerInterface $pimProducer, Serializer $serializer): void
    {
        $this->beConstructedWith($pimProducer, $serializer);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductPublisher::class);
    }

    function it_publishes_product_created_event(
        ProducerInterface $pimProducer,
        Serializer $serializer,
        ProductInterface $product,
        ResourceControllerEvent $event
    ): void {
        $product->getId()->willReturn(1);
        $product->getTitle()->willReturn('Fallout');
        $product->getPrice()->willReturn(['amount' => '199', 'currency' => 'USD']);
        $event->getSubject()->willReturn($product);
        $recordedOn = new \DateTimeImmutable();

        $message = ['type' => 'ProductCreated', 'payload' => $product, 'recordedOn' => $recordedOn->format('Y-m-d H:i:s')];

        $serializer
            ->serialize($message, 'json', new Context())
            ->willReturn('{"type": "ProductCreated", "payload": {"title": "Fallout", "price": {"amount": 199, "currency": "USD"}}, "recordedOn": "2017-05-07 00:50:08"}')
        ;

        $pimProducer->publish(
            '{"type": "ProductCreated", "payload": {"title": "Fallout", "price": {"amount": 199, "currency": "USD"}}, "recordedOn": "2017-05-07 00:50:08"}'
        )->shouldBeCalled();

        $this->publishProductCreated($event);
    }

    function it_publishes_product_updated_event(
        ProducerInterface $pimProducer,
        Serializer $serializer,
        ProductInterface $product,
        ResourceControllerEvent $event
    ): void {
        $product->getId()->willReturn(1);
        $product->getTitle()->willReturn('Fallout');
        $product->getPrice()->willReturn(['amount' => '199', 'currency' => 'USD']);
        $event->getSubject()->willReturn($product);
        $recordedOn = new \DateTimeImmutable();

        $message = ['type' => 'ProductUpdated', 'payload' => $product, 'recordedOn' => $recordedOn->format('Y-m-d H:i:s')];

        $serializer
            ->serialize($message, 'json', new Context())
            ->willReturn('{"type": "ProductUpdated", "payload": {"title": "Fallout", "price": {"amount": 199, "currency": "USD"}}, "recordedOn": "2017-05-07 00:50:08"}')
        ;

        $pimProducer->publish(
            '{"type": "ProductUpdated", "payload": {"title": "Fallout", "price": {"amount": 199, "currency": "USD"}}, "recordedOn": "2017-05-07 00:50:08"}'
        )->shouldBeCalled();

        $this->publishProductUpdated($event);
    }

    function it_published_product_deleted_event(
        ProducerInterface $pimProducer,
        Serializer $serializer,
        ProductInterface $product,
        ResourceControllerEvent $event
    ): void {
        $product->getId()->willReturn(1);
        $event->getSubject()->willReturn($product);
        $recordedOn = new \DateTimeImmutable();

        $message = ['type' => 'ProductDeleted', 'payload' => $product, 'recordedOn' => $recordedOn->format('Y-m-d H:i:s')];

        $serializer
            ->serialize($message, 'json', new Context())
            ->willReturn('{"type": "ProductDeleted", "payload": {"title": "Fallout", "price": {"amount": 199, "currency": "USD"}}, "recordedOn": "2017-05-07 00:50:08"}')
        ;

        $pimProducer->publish(
            '{"type": "ProductDeleted", "payload": {"title": "Fallout", "price": {"amount": 199, "currency": "USD"}}, "recordedOn": "2017-05-07 00:50:08"}'
        )->shouldBeCalled();

        $this->publishProductDeleted($event);
    }
}

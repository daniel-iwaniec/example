<?php

declare(strict_types = 1);

namespace Example\Web;

use Example\Web\Responder\Group\JsonResponder;
use Generator;
use IteratorAggregate;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ResponderMatcher implements EventSubscriberInterface
{
    /** @var ContainerInterface<Responder> */
    private ContainerInterface $responders;

    /** @var IteratorAggregate<int, Responder> */
    private IteratorAggregate $commonResponders;

    private ?Responder $responder = null;

    public function __construct(ContainerInterface $webResponders, IteratorAggregate $webCommonResponders)
    {
        $this->responders = $webResponders;
        $this->commonResponders = $webCommonResponders;
    }

    /**
     * @return Generator<string, string>
     */
    public static function getSubscribedEvents(): Generator
    {
        yield KernelEvents::CONTROLLER => 'createResponder';
        yield KernelEvents::VIEW => 'createResponse';
        yield KernelEvents::EXCEPTION => 'createExceptionResponse';
    }

    public function createResponder(ControllerEvent $event): void
    {
        $this->responder = $this->chooseResponder($event);
    }

    private function chooseResponder(ControllerEvent $event): Responder
    {
        if ($event->getRequest()->query->get('format') === 'json') {
            return $this->responders->get(JsonResponder::class);
        }

        try {
            $name = Responder::class . '\\' . (new ReflectionClass($event->getController()))->getShortName();

            return $this->responders->get($name);
        } catch (NotFoundExceptionInterface $exception) {
            foreach ($this->commonResponders as $responder) {
                if ($responder->matches($event->getRequest())) {
                    return $responder;
                }
            }
        }

        return $this->responders->get(JsonResponder::class);
    }

    public function createResponse(ViewEvent $event): void
    {
        if (!$this->responder) {
            return;
        }

        $event->setResponse(($this->responder)($event->getControllerResult()));
    }

    public function createExceptionResponse(ExceptionEvent $event): void
    {
        if (!$this->responder) {
            return;
        }

        $event->setResponse(($this->responder)($event->getThrowable()->getPrevious()));
    }
}

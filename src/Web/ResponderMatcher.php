<?php

declare(strict_types = 1);

namespace Example\Web;

use Generator;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ResponderMatcher implements EventSubscriberInterface
{
    private ContainerInterface $webResponders;

    private Responder $responder;

    public function __construct(ContainerInterface $webResponders)
    {
        $this->webResponders = $webResponders;
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
        $name = Responder::class . '\\' . (new ReflectionClass($event->getController()))->getShortName();
        $this->responder = $this->webResponders->get($name);
    }

    public function createResponse(ViewEvent $event): void
    {
        $event->setResponse(($this->responder)($event->getControllerResult()));
    }

    public function createExceptionResponse(ExceptionEvent $event): void
    {
        $event->setResponse(($this->responder)($event->getThrowable()->getPrevious()));
    }
}

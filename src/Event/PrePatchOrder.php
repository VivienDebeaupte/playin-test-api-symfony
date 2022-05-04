<?php

namespace App\Event;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PrePatchOrder implements EventSubscriberInterface
{

    public function __construct()
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['isAlreadyValidated', EventPriorities::PRE_READ],
        ];
    }

    public function isAlreadyValidated(ViewEvent $event): void
    {

        $order  = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$order instanceof Order || Request::METHOD_PATCH !== $method) {
            return;
        }

    }
}

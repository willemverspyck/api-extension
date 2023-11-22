<?php

namespace Spyck\ApiExtension\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final class KernelExceptionEventSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable()->getPrevious();

        if (false === $throwable instanceof ValidationFailedException) {
            return;
        }

        $format = $event->getRequest()->getPreferredFormat(JsonEncoder::FORMAT);

        if (JsonEncoder::FORMAT !== $format) {
            return;
        }

        $data = [];

        $violations = $throwable->getViolations();

        foreach ($violations as $violation) {
            $data[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        $response = new JsonResponse($data, Response::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', -32],
        ];
    }
}

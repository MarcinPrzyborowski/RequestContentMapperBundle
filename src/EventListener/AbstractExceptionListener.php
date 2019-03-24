<?php

declare(strict_types=1);

namespace RequestContentMapper\EventListener;

use RequestContentMapper\EventListener\Response\ExceptionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
abstract class AbstractExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        $instanceOfException = $this->supports($exception);
        if (!$instanceOfException) {
            return;
        }
        $response = $this->handleResponse($exception);
        $jsonResponse = new JsonResponse($response->errors, $response->httpCode);
        $event->setResponse($jsonResponse);
    }

    abstract public function supports(\Exception $exception): bool;

    abstract public function handleResponse($exception): ExceptionResponse;
}

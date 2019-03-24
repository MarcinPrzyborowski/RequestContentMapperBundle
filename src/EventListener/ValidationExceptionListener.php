<?php

declare(strict_types=1);

namespace RequestContentMapper\EventListener;

use RequestContentMapper\EventListener\Response\ExceptionResponse;
use RequestContentMapper\Validator\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
final class ValidationExceptionListener extends AbstractExceptionListener
{
    public function supports(\Exception $exception): bool
    {
        return $exception instanceof ValidationException;
    }

    /**
     * @param ValidationException $exception
     *
     * @return JsonResponse
     */
    public function handleResponse($exception): ExceptionResponse
    {
        return new ExceptionResponse(
            $exception->getErrors()
        );
    }
}

<?php

declare(strict_types=1);

namespace RequestContentMapper\EventListener;

use RequestContentMapper\EventListener\Response\ExceptionResponse;
use RequestContentMapper\Serializer\Exception\InvalidJsonException;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
final class InvalidJsonExceptionListener extends AbstractExceptionListener
{
    public function supports(\Exception $exception): bool
    {
        return $exception instanceof InvalidJsonException;
    }

    /**
     * @param InvalidJsonException $exception
     * @return ExceptionResponse
     */
    public function handleResponse($exception): ExceptionResponse
    {
        return new ExceptionResponse(
            ['Invalid Json Format']
        );
    }
}

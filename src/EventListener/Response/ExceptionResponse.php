<?php

declare(strict_types=1);

namespace RequestContentMapper\EventListener\Response;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
class ExceptionResponse
{
    const BAD_REQUEST = 400;

    public $errors;
    public $httpCode;

    public function __construct(array $errors, int $httpCode = self::BAD_REQUEST)
    {
        $this->errors['errors'] = $errors;
        $this->httpCode = $httpCode;
    }
}

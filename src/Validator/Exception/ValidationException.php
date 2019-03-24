<?php

declare(strict_types=1);

namespace RequestContentMapper\Validator\Exception;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
final class ValidationException extends \Exception
{
    private $errors = [];

    public function __construct(array $errors)
    {
        parent::__construct();
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

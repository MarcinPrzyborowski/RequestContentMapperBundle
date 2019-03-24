<?php

declare(strict_types=1);

namespace RequestContentMapper\Validator;

use RequestContentMapper\Validator\Exception\ValidationException;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * @param $value
     *
     * @throws ValidationException
     */
    public function validate($value): void;
}

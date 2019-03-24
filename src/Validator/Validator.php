<?php

declare(strict_types=1);

namespace RequestContentMapper\Validator;

use RequestContentMapper\Validator\Exception\ValidationException;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
final class Validator implements ValidatorInterface
{

    private const MESSAGE = '%s: %s';

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    public function __construct(\Symfony\Component\Validator\Validator\ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $value
     * @throws ValidationException
     */
    public function validate($value): void
    {
        $violations = $this->validator->validate($value);

        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = sprintf(self::MESSAGE, $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ValidationException($errors);
        }
    }
}

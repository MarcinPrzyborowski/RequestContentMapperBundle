<?php

declare(strict_types=1);

namespace RequestContentMapper\ParamConverter;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
abstract class RequestContentObject
{
    public function __construct(array $input = [])
    {
        foreach ($input as $property => $value) {
            $this->$property = $value;
        }
    }
}

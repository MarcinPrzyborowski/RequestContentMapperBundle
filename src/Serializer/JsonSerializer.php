<?php

declare(strict_types=1);

namespace RequestContentMapper\Serializer;

use RequestContentMapper\Serializer\Exception\InvalidJsonException;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
final class JsonSerializer implements SerializerInterface
{
    public function serialize($data): string
    {
        return \json_encode($data);
    }

    /**
     * @param $data
     * @return mixed
     * @throws InvalidJsonException
     */
    public function deserialize($data): array
    {
        if (!is_string($data)) {
            throw new InvalidJsonException();
        }

        $result = \json_decode((string)$data, true);

        if (null === $result) {
            throw new InvalidJsonException();
        }

        return $result;
    }
}

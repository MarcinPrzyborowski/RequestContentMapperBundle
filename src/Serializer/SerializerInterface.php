<?php

declare(strict_types=1);

namespace RequestContentMapper\Serializer;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
interface SerializerInterface
{
    public function serialize($data): string;

    public function deserialize($data): array;
}

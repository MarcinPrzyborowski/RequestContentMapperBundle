<?php

declare(strict_types=1);

namespace RequestContentMapper\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use RequestContentMapper\Serializer\Exception\InvalidJsonException;
use RequestContentMapper\Serializer\JsonSerializer;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
class JsonSerializerTest extends TestCase
{
    /**
     * @var JsonSerializer
     */
    private $serializer;

    protected function setUp()
    {
        $this->serializer = new JsonSerializer();
    }

    /**
     * @dataProvider serializerDataProvider
     *
     * @param $data
     * @param $expected
     */
    public function test_Serialize_Should_ReturnString($data, $expected)
    {
        $serializedData = $this->serializer->serialize($data);

        $this->assertEquals($expected, $serializedData);
    }

    public function serializerDataProvider()
    {
        return [
            'null' => [null, 'null'],
            'int' => [1, '1'],
            'array' => [[], '[]'],
            'boolean' => [true, 'true'],
            'object' => [new \stdClass(), '{}'],
            'emptyString' => ['', '""'],
        ];
    }

    /**
     * @dataProvider invalidJsonDataProvider
     * @expectedException \RequestContentMapper\Serializer\Exception\InvalidJsonException
     *
     * @param $invalidJson
     *
     * @throws InvalidJsonException
     */
    public function test_Deserialize_Should_ThrowInvalidJsonException_When_JsonIsInvalid($invalidJson)
    {
        $this->serializer->deserialize($invalidJson);
    }

    public function invalidJsonDataProvider()
    {
        return [
            'null' => [null],
            'int' => [1],
            'array' => [[]],
            'boolean' => [true],
            'object' => [new \stdClass()],
            'emptyString' => [''],
            'invalidJsonArray' => ['["]'],
            'invalidJson' => ['{"1" : [}'],
        ];
    }

    /**
     * @dataProvider validJsonDataProvider
     *
     * @param $validJson
     * @param $expected
     * @param $assoc
     *
     * @throws InvalidJsonException
     */
    public function test_Deserialize_Should_ReturnArray_When_JsonIsCorrect($validJson, $expected)
    {
        $deserializedData = $this->serializer->deserialize($validJson);

        $this->assertEquals($expected, $deserializedData);
    }

    public function validJsonDataProvider()
    {
        return [
            'validJson' => ['{"1" : "abc"}', [1 => 'abc']],
            'validNestedJson' => ['{"1" : {"abc": "1"} }', [1 => ['abc' => 1]]],
            'validArrayJson' => ['[{"a": 1},{"b": 2}]', [['a' => 1], ['b' => 2]]],
        ];
    }
}

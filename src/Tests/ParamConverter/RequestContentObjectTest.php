<?php

declare(strict_types=1);

namespace RequestContentMapper\Tests\ParamConverter;

use PHPUnit\Framework\TestCase;
use RequestContentMapper\ParamConverter\RequestContentObject;
use RequestContentMapper\Tests\ParamConverter\Stub\RequestContentObjectStub;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
class RequestContentObjectTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     * @param $data
     * @param $expected
     */
    public function test_CreateNewObject_Should_ReturnObject_With_CorrectData($data, $expected)
    {
        $obj = new RequestContentObjectStub($data);

        $this->assertInstanceOf(RequestContentObject::class, $obj);
        $this->assertEquals($expected[0], $obj->a);
        $this->assertEquals($expected[1], $obj->b);
        $this->assertEquals($expected[2], $obj->c);
    }

    public function dataProvider()
    {
        return [
            'strings' => [['a' => 'a', 'b' => 'b', 'c' => 'c'], ['a', 'b', 'c']],
            'integers' => [['a' => 1, 'b' => 2, 'c' => 1], [1, 2, 1]],
            'booleans' => [['a' => true, 'b' => true, 'c' => false], [true, true, false]],
            'arrays' => [['a' => ['a'], 'b' => ['b'], 'c' => ['c']], [['a'], ['b'], ['c']]],
            'objects' => [
                ['a' => new \stdClass(), 'b' => new \stdClass(), 'c' => new \stdClass()],
                [new \stdClass(), new \stdClass(), new \stdClass()]
            ],
        ];
    }

}
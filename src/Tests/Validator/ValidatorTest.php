<?php

declare(strict_types=1);

namespace RequestContentMapper\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use RequestContentMapper\Validator\Validator;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Marcin Przyborowski <hiprzyborowski@gmail.com>
 */
class ValidatorTest extends TestCase
{
    /**
     * @var ValidatorInterface|ObjectProphecy
     */
    private $sfValidator;

    /**
     * @var Validator
     */
    private $validator;

    protected function setUp()
    {
        $this->sfValidator = $this->prophesize(ValidatorInterface::class);

        $this->validator = new Validator($this->sfValidator->reveal());
    }

    /**
     * @throws \RequestContentMapper\Validator\Exception\ValidationException
     */
    public function test_Validate_Should_NothingHappend_When_ObjectIsValid()
    {
        $validObject = new \stdClass();
        $constraintList = new ConstraintViolationList([]);
        $this->sfValidator->validate($validObject)->willReturn($constraintList)->shouldBeCalledTimes(1);
        $result = $this->validator->validate($validObject);
        $this->assertNull($result);
    }

    /**
     * @expectedException \RequestContentMapper\Validator\Exception\ValidationException
     *
     * @throws \RequestContentMapper\Validator\Exception\ValidationException
     */
    public function test_Validate_Should_ThrowException_When_ObjectIsInvalid()
    {
        $validObject = new \stdClass();

        $constraintViolation = $this->prophesize(ConstraintViolationInterface::class);
        $constraintViolation->getPropertyPath()->willReturn('a')->shouldBeCalledTimes(1);
        $constraintViolation->getMessage()->willReturn('b')->shouldBeCalledTimes(1);

        $constraintList = new ConstraintViolationList([
            $constraintViolation->reveal(),
        ]);

        $this->sfValidator->validate($validObject)->willReturn($constraintList);
        $this->validator->validate($validObject);
    }
}

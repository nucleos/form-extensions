<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Form\Tests\Validator\Constraints;

use DateTime;
use InvalidArgumentException;
use Nucleos\Form\Model\BatchTime;
use Nucleos\Form\Tests\Fixtures\DummyConstraint;
use Nucleos\Form\Validator\Constraints\BatchTimeAfter;
use Nucleos\Form\Validator\Constraints\BatchTimeAfterValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class BatchTimeAfterValidatorTest extends ConstraintValidatorTestCase
{
    public function testValidateInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "Nucleos\Form\Validator\Constraints\BatchTimeAfter", "Nucleos\Form\Tests\Fixtures\DummyConstraint" given');

        $this->validator->validate('dummy', new DummyConstraint());
    }

    public function testValidateInvalidObject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Could not validate "string"');

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate('dummy', $constraint);
    }

    public function testValidateInvalidFirstField(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $end = new BatchTime();
        $end->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getEnd'])
            ->getMock()
        ;
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate($object, $constraint);
    }

    public function testValidateInvalidSecondField(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $begin = new BatchTime();
        $begin->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate($object, $constraint);
    }

    public function testValidateInvalidFirstValue(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $begin = new BatchTime();
        $begin->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn('test');

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate($object, $constraint);
    }

    public function testValidateInvalidSecondValue(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $end = new BatchTime();
        $end->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn('test');
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate($object, $constraint);
    }

    public function testValidateEmptyFirstValue(): void
    {
        $end = new BatchTime();
        $end->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn(null);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->emptyMessage)
            ->setParameter('%emptyField%', $constraint->firstField)
            ->setParameter('%field%', $constraint->secondField)
            ->atPath($constraint->firstField)
            ->assertRaised()
        ;
    }

    public function testValidateEmptySecondValue(): void
    {
        $begin = new BatchTime();
        $begin->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn(null);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->emptyMessage)
            ->setParameter('%emptyField%', $constraint->secondField)
            ->setParameter('%field%', $constraint->firstField)
            ->atPath($constraint->secondField)
            ->assertRaised()
        ;
    }

    public function testValidateDatesInvalid(): void
    {
        $begin = new BatchTime();
        $begin->setTime(new DateTime('2015-02-01 10:00'));

        $end = new BatchTime();
        $end->setTime(new DateTime('2015-01-01 10:00'));

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('%firstField%', $constraint->firstField)
            ->setParameter('%secondField%', $constraint->secondField)
            ->atPath($constraint->secondField)
            ->assertRaised()
        ;
    }

    public function testValidateDatesValid(): void
    {
        $begin = new BatchTime();
        $begin->setTime(new DateTime('2015-01-01 10:00'));

        $end = new BatchTime();
        $end->setTime(new DateTime('2015-02-01 10:00'));

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate($object, $constraint);

        $this->assertNoViolation();
    }

    public function testValidateEqualDate(): void
    {
        $begin = new BatchTime();
        $begin->setTime(new DateTime('2015-01-01 10:00'));

        $end = new BatchTime();
        $end->setTime(new DateTime('2015-01-01 10:00'));

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->validator->validate($object, $constraint);

        $this->assertNoViolation();
    }

    public function testValidateNotRequired(): void
    {
        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn(null);
        $object->method('getEnd')->willReturn(null);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
                'required'    => false,
            ]
        );

        $this->validator->validate($object, $constraint);

        $this->assertNoViolation();
    }

    public function testValidateNotRequiredWithEmptyFirst(): void
    {
        $end = new BatchTime();
        $end->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn(null);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
                'required'    => false,
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->emptyMessage)
            ->setParameter('%emptyField%', $constraint->firstField)
            ->setParameter('%field%', $constraint->secondField)
            ->atPath($constraint->firstField)
            ->assertRaised()
        ;
    }

    public function testValidateNotRequiredWithEmptySecond(): void
    {
        $begin = new BatchTime();
        $begin->setTime(new DateTime());

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn(null);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
                'required'    => false,
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->emptyMessage)
            ->setParameter('%emptyField%', $constraint->secondField)
            ->setParameter('%field%', $constraint->firstField)
            ->atPath($constraint->secondField)
            ->assertRaised()
        ;
    }

    public function testValidateEmptyFirstValueDate(): void
    {
        $begin = new BatchTime();

        $end = new BatchTime();
        $end->setTime(new DateTime('2015-02-01 10:00'));

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->emptyMessage)
            ->setParameter('%emptyField%', $constraint->firstField)
            ->setParameter('%field%', $constraint->secondField)
            ->atPath($constraint->firstField)
            ->assertRaised()
        ;
    }

    public function testValidateEmptySecondValueDate(): void
    {
        $begin = new BatchTime();
        $begin->setTime(new DateTime('2015-01-01 10:00'));

        $end = new BatchTime();

        $object = $this->getMockBuilder('stdClass')
            ->setMethods(['getBegin', 'getEnd'])
            ->getMock()
        ;
        $object->method('getBegin')->willReturn($begin);
        $object->method('getEnd')->willReturn($end);

        $constraint = new BatchTimeAfter(
            [
                'firstField'  => 'begin',
                'secondField' => 'end',
            ]
        );

        $this->setPropertyPath('');

        $this->validator->validate($object, $constraint);

        $this->buildViolation($constraint->emptyMessage)
            ->setParameter('%emptyField%', $constraint->secondField)
            ->setParameter('%field%', $constraint->firstField)
            ->atPath($constraint->secondField)
            ->assertRaised()
        ;
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new BatchTimeAfterValidator();
    }
}

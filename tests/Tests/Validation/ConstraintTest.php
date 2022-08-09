<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests\Validation;

use MAKS\Mighty\Validation;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectInterface;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectTrait;
use MAKS\Mighty\TestCase;
use MAKS\Mighty\Mocks\ValidatableObject;
use MAKS\Mighty\Mocks\ValidatableObjectChild;
use MAKS\Mighty\Exception\ValidationLogicException;
use MAKS\Mighty\Exception\ValidationFailedException;

class ConstraintTest extends TestCase
{
    public function testConstraintAsAStanaloneClass(): void
    {
        $constraint = new Constraint(
            Validation::string()->min(3),
            [
                'string' => 'Must be string.',
                'min'    => 'Must be longer than ${@arguments.0}.',
            ],
            Strategy::FailLazy,
        );

        $this->assertEquals($constraint->getValidation(), 'string&min:3');
        $this->assertEquals($constraint->getStrategy(), Strategy::FailLazy);
        $this->assertEquals($constraint->getMessages(), [
            'string' => 'Must be string.',
            'min'    => 'Must be longer than ${@arguments.0}.',
        ]);

        $this->assertTrue($constraint->isValid('string'));
        $this->assertFalse($constraint->isValid('X'));

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('Must be longer than 3');

        $constraint->check('X');

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('Must be string');
        $this->expectExceptionMessage('Must be longer than 3');

        $constraint->check(null);

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessageMatches('/(Must be string)/');
        $this->expectExceptionMessageMatches('/((?!Must be longer than 3).)*/'); // does not contain

        $constraint->setStrategy(Strategy::FailFast);
        $constraint->check(1);
    }

    public function testConstraintsOnAValideValidatableObject(): void
    {
        $object = new ValidatableObject();
        $object->object = new ValidatableObjectChild();

        $this->assertNull($object->check());
        $this->assertTrue($object->isValid());
        $this->assertIsArray($object->validate());
    }

    public function testConstraintsOnAValidatableObjectThrowExceptionIfDataIsInvalid(): void
    {
        $object = new ValidatableObject();
        $object->object = null;

        $this->assertFalse($object->isValid());
        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('Data failed to pass the validation');
        $this->expectExceptionMessage('ValidatableObject->child');
        $this->expectExceptionMessage('Child object is invalid');

        $object->check();
    }

    public function testConstraintsOnAValidatableObjectThatHasConstraintWithFailFastStrategy(): void
    {
        $object = new ValidatableObject();
        $object->array = null;

        $this->assertFalse($object->isValid());
        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('Data failed to pass the validation');
        $this->expectExceptionMessage('ValidatableObject->array.string');
        $this->expectExceptionMessage('String must be a string');

        // to cover subressed exceptions
        $object->validate();

        // to cover thrown exceptions
        $object->check();
    }

    public function testConstraintsOnAValidatableObjectThatHasConstraintOnAMethodWithRequiredParameters(): void
    {
        $object = new class () implements ValidatableObjectInterface {
            use ValidatableObjectTrait;


            #[Constraint\Rule\Boolean]
            public function is(bool $boolean)
            {
                return $boolean;
            }
        };

        $this->expectException(ValidationLogicException::class);
        $this->expectExceptionMessageMatches('/(Cannot validate methods that have required parameters)/');
        $this->expectExceptionMessageMatches('/(has \d+ required parameter)/');

        $object->check();
    }

    public function testValidatableObjectTraitThrowsAnExceptionIfUsedOnANoneValidatableObjectInterface(): void
    {
        $object = new class () {
            use ValidatableObjectTrait;
        };

        try {
            $object->check();
        } catch (\Exception $error) {
            $this->assertStringContainsString(
                'must implement ' . ValidatableObjectInterface::class,
                $error->getMessage()
            );
        }
    }
}

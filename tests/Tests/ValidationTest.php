<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests;

use MAKS\Mighty\Validator;
use MAKS\Mighty\Validation;
use MAKS\Mighty\TestCase;
use MAKS\Mighty\Exception\ValidationLogicException;
use MAKS\Mighty\Exception\InvalidValidationExpressionException;

class ValidationTest extends TestCase
{
    private Validation $validation;


    public function setUp(): void
    {
        parent::setUp();

        $this->validation = new Validation();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->validation);
    }


    public function testValidationFluentInterface(): void
    {
        $this->assertEquals(
            'null|(string&string.contains:"substring")',
            (new Validation())
                ->null()
                ->or()
                ->group(static fn ($validation) => $validation
                ->string()
                ->and()
                ->stringContains('substring'))
                ->build()
        );

        $this->assertEquals(
            'null^~empty',
            (new Validation())
                ->null()
                ->xor()
                ->not()
                ->empty()
                ->build()
        );

        $this->assertEquals(
            '?string|scalar',
            (new Validation())
                ->string()
                ->or()
                ->scalar()
                ->optimistic()
                ->build()
        );

        $this->assertEquals(
            '!if:${field.validations.present},true,"==="&required',
            (new Validation())
                ->if(Validation::variable('field.validations.present'), true, '===')
                ->and()
                ->required()
                ->pessimistic()
                ->build()
        );

        $this->assertEquals(
            '(integer|(string&numeric))^[nullable]',
            Validation::new()
                ->group(function () {
                    /** @var Validation $this */
                    $this->rule('integer')->or()->open()->string()->and()->numeric()->close();
                })
                ->xor()
                ->macro('nullable')
                ->optimistic()
                ->normal()
                ->build()
        );
    }

    public function testValidationBuildMethodThrowsAnExceptionWithInvalidExpressions(): void
    {
        $this->expectException(InvalidValidationExpressionException::class);
        $this->expectExceptionMessage('Invalid expression string');
        $this->expectExceptionMessage('no rules were added (expression string is empty)');
        // empty
        (new Validation())->build();

        $this->expectException(InvalidValidationExpressionException::class);
        $this->expectExceptionMessage('Invalid expression string');
        $this->expectExceptionMessage('precedence parentheses are not balanced');
        // has unbalanced parentheses
        (new Validation())->string()->open()->integer()->build();

        $this->expectException(InvalidValidationExpressionException::class);
        $this->expectExceptionMessage('Invalid expression string');
        $this->expectExceptionMessage('starts with an operator like "&, |, ^" or ends with an operator like "~, &, |, ^"');
        // ends with an operator
        (new Validation())->required()->not()->build();

        $this->expectException(InvalidValidationExpressionException::class);
        $this->expectExceptionMessage('Invalid expression string');
        $this->expectExceptionMessage('an operator like "&, |, ^" is repeated more than once consecutively');
        // has conscutive operators
        (new Validation())->string()->and()->or()->integer()->build();
    }

    public function testValidationWhenTheObjectIsBountToAValidator(): void
    {
        $validator = new Validator();

        $validation = (new Validation($validator))
            ->password()
            ->callback(static fn () => /* "Have I Been Pwned" check */ true, 'notPwned')
            ->pessimistic()
            ->build();

        $this->assertEquals(
            '!password&callback.notPwned',
            $validation
        );

        $this->assertArrayHasKey(
            'callback.notPwned',
            $validator->getRules()
        );

        $this->expectException(ValidationLogicException::class);
        $this->expectExceptionMessage(
            strtr('Cannot use a callback rule in a {validation} instance that is not bound to an instance of {validator}', [
                '{validation}' => Validation::class,
                '{validator}'  => Validator::class,
            ])
        );

        (new Validation())->add($validation)->callback(fn () => 'This should fail!')->build();
    }
}

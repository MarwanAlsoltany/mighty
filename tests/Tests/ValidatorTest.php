<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests;

use MAKS\Mighty\TestCase;
use MAKS\Mighty\Validator;
use MAKS\Mighty\Result;
use MAKS\Mighty\Exception\UnknownValidationRuleException;
use MAKS\Mighty\Exception\InvalidRuleDefinitionException;
use MAKS\Mighty\Exception\InvalidRuleAliasException;
use MAKS\Mighty\Exception\InvalidRuleMacroException;
use MAKS\Mighty\Exception\InvalidBitwiseExpressionException;

class ValidatorTest extends TestCase
{
    private Validator $validator;


    public function setUp(): void
    {
        parent::setUp();

        $this->validator = new Validator(null, null, false);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->validator);
    }


    public function testValidatorValidateOneMethod(): void
    {
        // test with a normal rules string
        $result = $this->validator->validateOne('string', 'required&string&length:6');

        $this->assertInstanceOf(Result::class, $result);
        $this->assertInstanceOf(\ArrayAccess::class, $result);
        $this->assertInstanceOf(\Traversable::class, $result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('validations', $result);
        $this->assertArrayHasKey('result', $result);
        $this->assertArrayHasKey('metadata', $result);
        $this->assertArrayHasKey('rules', $result['metadata']);
        $this->assertArrayHasKey('basis', $result['metadata']);
        $this->assertArrayHasKey('expression', $result['metadata']);

        $this->assertIsString($result['value']);
        $this->assertIsArray($result['validations']);
        $this->assertIsString($result['metadata']['basis']);
        $this->assertIsString($result['metadata']['rules']);
        $this->assertIsString($result['metadata']['expression']);
        $this->assertIsBool($result['result']);

        $this->assertTrue($result['validations']['required']);
        $this->assertTrue($result['validations']['string']);
        $this->assertTrue($result['validations']['length']);

        // test with a bailable rules string
        $result = $this->validator->validateOne(null, '!allowed^(string|integer)');

        $this->assertTrue($result['result']);
        $this->assertTrue($result['validations']['allowed']);
        $this->assertFalse($result['validations']['string']);
        $this->assertNull($result['validations']['integer']);
    }

    public function testValidatorValidateOneMethodWithAnInvalidRulesString(): void
    {
        $this->expectException(InvalidBitwiseExpressionException::class);
        $this->expectDeprecationMessageMatches('/Invalid bitwise expression/');
        $this->expectDeprecationMessageMatches('/Infinite loop detected/');

        // test with a malformed rules string, parentheses are not balanced
        $this->validator->validateOne('123', 'numeric|(string&equals:123');
    }

    public function testValidatorValidateOneMethodThrowsAnExceptionForUnknownRules(): void
    {
        $this->expectException(UnknownValidationRuleException::class);
        $this->expectExceptionMessageMatches('Unknown rule');
        $this->expectExceptionMessageMatches('(no matches found)');

        $this->validator->validateOne(null, 'unknown');
    }

    public function testValidatorValidateAllMehtod(): void
    {
        $data        = $this->getTestData();
        $validations = $this->getTestValidations();

        $results = $this->validator->validateAll($data, $validations);

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        $this->assertArrayHasKey('name', $results);
        $this->assertArrayNotHasKey('empty', $results);
        $this->assertInstanceOf(Result::class, $results['name']);
        $this->assertInstanceOf(\ArrayAccess::class, $results['name']);
        $this->assertInstanceOf(\Traversable::class, $results['name']);
        $this->assertArrayHasKey('key', $results['name']);
        $this->assertArrayHasKey('value', $results['name']);
        $this->assertArrayHasKey('validations', $results['name']);
        $this->assertArrayHasKey('metadata', $results['name']);
        $this->assertArrayHasKey('result', $results['name']);
        $this->assertArrayHasKey('basis', $results['name']['metadata']);
        $this->assertArrayHasKey('rules', $results['name']['metadata']);
        $this->assertArrayHasKey('expression', $results['name']['metadata']);

        $this->assertTrue($results['name']['validations']['required']);
        $this->assertTrue($results['name']['validations']['string']);
        $this->assertTrue($results['name']['validations']['min']);
        $this->assertTrue($results['name']['validations']['max']);
        $this->assertEquals($results['name']['metadata']['expression'], '1&1&1&1');
        $this->assertEquals($results['name']['result'], true);

        $this->assertArrayHasKey('age', $results);
        $this->assertArrayHasKey('validations', $results['age']);
        $this->assertArrayHasKey('metadata', $results['age']);
        $this->assertArrayHasKey('rules', $results['age']['metadata']);
        $this->assertTrue($results['age']['validations']['integer']);
        $this->assertFalse($results['age']['validations']['min']);
        $this->assertTrue($results['age']['validations']['max']);
        $this->assertEquals($results['age']['metadata']['expression'], '1&0&1');
        $this->assertEquals($results['age']['result'], false);

        $this->assertTrue($results['username']['validations']['email']);
        $this->assertFalse($results['username']['validations']['alnum']);
        $this->assertEquals($results['username']['metadata']['expression'], '1^0');
        $this->assertEquals($results['username']['result'], true);

        $this->assertTrue($results['hobbies']['validations']['array']);
        $this->assertTrue($results['hobbies']['validations']['min']);
        $this->assertEquals($results['hobbies']['metadata']['expression'], '1&1');
        $this->assertEquals($results['hobbies']['result'], true);

        $this->assertTrue($results['hobbies.0']['validations']['string']);
        $this->assertTrue($results['hobbies.0']['validations']['min']);
        $this->assertTrue($results['hobbies.0']['validations']['in']);
        $this->assertEquals($results['hobbies.0']['metadata']['expression'], '1&1&1');
        $this->assertEquals($results['hobbies.0']['result'], true);

        $this->assertTrue($results['hobbies.1']['validations']['null']);
        $this->assertFalse($results['hobbies.1']['validations']['string']);
        $this->assertFalse($results['hobbies.1']['validations']['min']);
        $this->assertEquals($results['hobbies.1']['metadata']['expression'], '1|(0&0)');
        $this->assertEquals($results['hobbies.1']['result'], true);

        $this->assertTrue($results['verified']['validations']['boolean']);
        $this->assertTrue($results['verified']['validations']['equals']);
        $this->assertEquals($results['verified']['metadata']['expression'], '1&1');
        $this->assertEquals($results['verified']['result'], true);
    }

    public function testValidatorValidateAllMehtodWithAReferenceToAValueNotCastableToAnInteger(): void
    {
        $results = $this->validator->validateAll(
            [
                'hobby'   => new \stdClass(),
                'hobbies' => ['hobby1', 'hobby2', 'hobby3'],
            ],
            [
                'hobby'     => 'object',
                // ${hobby.value} should result in a suppressed notice,
                // can't cast an object to integer, will fall back to zero although the value is truthy
                'hobbies'   => 'if:${hobby.value}&array&min:1',
            ]
        );

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        $this->assertArrayHasKey('hobby', $results);
        $this->assertArrayHasKey('hobbies', $results);
        $this->assertTrue($results['hobby']['result']);
        $this->assertFalse($results['hobbies']['result']);
    }

    public function testValidatorValidateMehtod(): void
    {
        $data        = $this->getTestData();
        $validations = $this->getTestValidations();

        $this->validator
            ->setData($data)
            ->setValidations($validations)
            ->validate();

        $isValid = $this->validator->isOK();
        $results = $this->validator->getResults();
        $errors  = $this->validator->getErrors();

        $this->assertFalse($isValid);

        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        $this->assertArrayHasKey('name', $results);

        $this->assertIsArray($errors);
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('age', $errors);
    }

    public function testValidatorValidateDataMehtod(): void
    {
        $result = Validator::validateData('string', 'string&min:2&max:255');

        $this->assertInstanceOf(Result::class, $result);
        $this->assertInstanceOf(\ArrayAccess::class, $result);
        $this->assertInstanceOf(\Traversable::class, $result);
        $this->assertFalse(isset($result['key']));
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('validations', $result);
        $this->assertArrayHasKey('metadata', $result);
        $this->assertArrayHasKey('result', $result);
        $this->assertArrayHasKey('basis', $result['metadata']);
        $this->assertArrayHasKey('rules', $result['metadata']);
        $this->assertArrayHasKey('expression', $result['metadata']);
        $this->assertTrue($result['result']);

        $data        = $this->getTestData();
        $validations = $this->getTestValidations();

        $result = Validator::validateData($data, $validations);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('age', $result);
        $this->assertArrayHasKey('username', $result);
        $this->assertArrayHasKey('hobbies', $result);
        $this->assertArrayHasKey('verified', $result);
        $this->assertArrayNotHasKey('empty', $result);
    }

    public function testValidatorThrowsAnExceptionIfAMalformedValidationStringIsPassed(): void
    {
        $this->expectException(InvalidBitwiseExpressionException::class);
        $this->expectExceptionMessage('Invalid bitwise expression');

        Validator::validateData('string', 'required(string)'); // missing &
    }

    public function testValidatorThrowsAnExceptionIfAnEmptyValidationIsPassed(): void
    {
        $this->expectException(InvalidBitwiseExpressionException::class);
        $this->expectExceptionMessage('Invalid bitwise expression');
        $this->expectExceptionMessage('Problem(s): expression string is empty');

        Validator::validateData(null, '');
    }

    public function testValidatorFallsBackToAnEmptyRulesArrayIfRulesFileDoesNotExist(): void
    {
        $validator = new class extends Validator {
            protected const DEFAULT_RULES_PATH = '/path/to/non/existing/rules.php';
        };

        $this->assertEmpty($validator->getRules());
        $this->assertNotEmpty($this->validator->getRules());
    }

    public function testValidatorAddRuleMethod(): void
    {
        $this->validator->addRule([
            '@name'        => 'testRule',
            '@arguments'   => null,
            '@callback'    => null,
            '@parameters'  => null,
            '@comparison'  => null,
            '@example'     => 'testRule',
            '@description' => 'Test rule',
        ]);

        $this->assertArrayHasKey('testRule', $this->validator->getRules());
    }

    public function testValidatorAddRuleMethodThrowsAnExceptionIfRuleDefinitionIsInvalid(): void
    {
        $this->expectException(InvalidRuleDefinitionException::class);
        $this->expectDeprecationMessageMatches('/Invalid rule definition/');
        $this->expectDeprecationMessageMatches('/Data failed to pass the validation/');

        $this->validator->addRule([]);
    }

    public function testValidatorAddRuleAliasMethod(): void
    {
        $this->validator->addAlias('testAlias', 'string');

        $this->assertArrayHasKey('testAlias', $this->validator->getAliases());
    }

    public function testValidatorAddRuleAliasMethodThrowsAnExceptionIfRuleDefinitionIsInvalid(): void
    {
        $this->expectException(InvalidRuleAliasException::class);
        $this->expectDeprecationMessageMatches('/Invalid rule alias/');
        $this->expectDeprecationMessageMatches('/Data failed to pass the validation/');

        $this->validator->addAlias('', '');
    }

    public function testValidatorAddRuleMacroMethod(): void
    {
        $this->validator->addMacro('testMacro', 'string&max:255');

        $this->assertArrayHasKey('[testMacro]', $this->validator->getMacros());
    }

    public function testValidatorAddRuleMacroMethodThrowsAnExceptionIfRuleDefinitionIsInvalid(): void
    {
        $this->expectException(InvalidRuleMacroException::class);
        $this->expectDeprecationMessageMatches('/Invalid rule macro/');
        $this->expectDeprecationMessageMatches('/Data failed to pass the validation/');

        $this->validator->addMacro('', '');
    }


    private function getTestData(): array
    {
        return [
            'name'     => 'John Doe',
            'username' => 'john@domain.tld',
            'age'      => 17,
            'hobbies'  => ['coding', null],
            'verified' => true,
            'empty'    => null,
        ];
    }

    private function getTestValidations(): array
    {
        return [
            'name'      => 'required&string&min:3&max:255',
            'age'       => 'integer&min:18&max:99',
            'username'  => 'email^alnum',
            'hobbies'   => '!array&min:1',
            'hobbies.0' => 'string&min:3&in:coding,sport',
            'hobbies.1' => 'null|(string&min:3)',
            'verified'  => 'boolean&equals:1',
            'empty'     => '', // this should be ignored
        ];
    }
}

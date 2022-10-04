<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests;

use MAKS\Mighty\Engine;
use MAKS\Mighty\Exception\InvalidBitwiseExpressionException;
use MAKS\Mighty\TestCase;

class EngineTest extends TestCase
{
    private Engine $engine;


    public function setUp(): void
    {
        parent::setUp();

        $this->engine = new Engine();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->engine);
    }

    public function testEngineCreateRuleNameMethod(): void
    {
        $this->assertEquals('namespace.ruleName', $this->engine->createRuleName('namespace.ruleName'));

        $this->assertEquals('namespace.ruleName', $this->engine->createRuleName('namespaceRuleName'));

        $this->assertEquals('namespace.ruleName', $this->engine->createRuleName('namespace_rule-Name'));
    }

    public function testEngineCreateRuleArgumentsMethod(): void
    {
        $this->assertEquals('', $this->engine->createRuleArguments([]));

        $this->assertEquals('null', $this->engine->createRuleArguments([null]));

        $this->assertEquals('true', $this->engine->createRuleArguments([true]));

        $this->assertEquals('false', $this->engine->createRuleArguments([false]));

        $this->assertEquals('0', $this->engine->createRuleArguments([0]));

        $this->assertEquals('1.23', $this->engine->createRuleArguments([1.23]));

        $this->assertEquals('"string"', $this->engine->createRuleArguments(['string']));

        $this->assertEquals('\'"scalar & escaped"\'', $this->engine->createRuleArguments(['scalar & escaped']));

        $this->assertEquals('\'[1,"two",{"three":3}]\'', $this->engine->createRuleArguments([[1, 'two', ['three' => 3]]]));

        $this->assertEquals('\'{"scalar":"object"}\'', $this->engine->createRuleArguments([(object)("object")]));

        $this->assertEquals('"stringable"', $this->engine->createRuleArguments([new class {
            public function __toString()
            {
                return 'stringable';
            }
        }]));

        $this->assertEquals('null,123,"string",\'["array"]\'', $this->engine->createRuleArguments([
            null,
            123,
            'string',
            ['array']
        ]));
    }

    public function testEngineCreateRuleStatementMethod(): void
    {
        $this->assertEquals(
            'required',
            $this->engine->createRuleStatement(
                $this->engine->createRuleName('required'),
                $this->engine->createRuleArguments([])
            )
        );

        $this->assertEquals(
            'array.subset:\'{"key":"value"}\'',
            $this->engine->createRuleStatement(
                $this->engine->createRuleName('arraySubset'),
                $this->engine->createRuleArguments([['key' => 'value']])
            )
        );
    }

    public function testEngineParseRuleMethod(): void
    {
        $this->assertEquals(
            [
                'name'      => 'required',
                'arguments' => [],
            ],
            $this->engine->parseRule('required', [])
        );

        $this->assertEquals(
            [
                'name'      => 'array.subset',
                'arguments' => [
                    [
                        'key' => 'value',
                    ]
                ],
            ],
            $this->engine->parseRule('array.subset:{"key":"value"}', ['array'])
        );

        $this->assertEquals(
            [
                'name'      => 'string.contains',
                'arguments' => [
                    'substring', // search
                    true, // case-sensitive
                ],
            ],
            $this->engine->parseRule('string.contains:substring,1', ['string', 'bool'])
        );

        $this->assertEquals(
            [
                'name'      => 'in',
                'arguments' => [
                    0 => ['foo', 'bar', 'baz']
                ],
            ],
            $this->engine->parseRule('in:foo,bar,baz', ['...string'])
        );

        // assert memozation
        $this->assertNotEmpty($this->engine->parseRule('in:foo,bar,baz', ['...string']));
    }

    public function testEngineCleanExpressionMethod(): void
    {
        $expected = 'required&((object&object.isInstanceOf:"\\\\Namespace\\\\Class"|object.hasMethod:"getValue")|(array&array.isAssociative&array.hasKey:"key"&array.hasValue:"value"&array.subset:{"other":null})&min:2)';
        $actual   = <<<'JS'
            required & (
                /*
                    value can be an object or an array,
                    each type must adhere to some guidelines
                */
                (
                    object &
                    // class should the expected properties
                    object.isInstanceOf: "\\Namespace\\Class" |
                    object.hasMethod: "getValue"
                ) | (
                    array &
                    array.isAssociative &
                    array.hasKey: "key" & # required key
                    array.hasValue: "value" &
                    array.subset: {"other": null} # optional subset
                    // use ${this} to retrieve current value
                ) &
                min: 2
            )
        JS;

        $this->assertEquals($expected, $this->engine->cleanExpression($actual));

        // assert memozation
        $this->assertNotEmpty($this->engine->cleanExpression($actual));
    }

    public function testEngineParseExpressionMethod(): void
    {
        $actual   = 'required&((object&object.isInstanceOf:"\\\\Namespace\\\\Class"|object.hasMethod:"getValue")|(array&array.isAssociative&array.hasKey:"key"&array.hasValue:"value"&array.subset:{"other":null})&min:2)';
        $expected = [
            [
                'name' => 'required',
                'statement' => 'required',
            ],
            [
                'name' => 'object',
                'statement' => 'object',
            ],
            [
                'name' => 'object.isInstanceOf',
                'statement' => 'object.isInstanceOf:"\\\\Namespace\\\\Class"',
            ],
            [
                'name' => 'object.hasMethod',
                'statement' => 'object.hasMethod:"getValue"',
            ],
            [
                'name' => 'array',
                'statement' => 'array',
            ],
            [
                'name' => 'array.isAssociative',
                'statement' => 'array.isAssociative',
            ],
            [
                'name' => 'array.hasKey',
                'statement' => 'array.hasKey:"key"',
            ],
            [
                'name' => 'array.hasValue',
                'statement' => 'array.hasValue:"value"',
            ],
            [
                'name' => 'array.subset',
                'statement' => 'array.subset:{"other":null}',
            ],
            [
                'name' => 'min',
                'statement' => 'min:2',
            ],
        ];

        $this->assertEquals($expected, $this->engine->parseExpression($actual));

        // assert memozation
        $this->assertNotEmpty($this->engine->parseExpression($actual));
    }

    public function testEngineEvaluateExpressionMethod(): void
    {
        $actual   = 'required&((object&object.isInstanceOf:"\\\\Namespace\\\\Class"|object.hasMethod:"getValue")|(array&array.isAssociative&array.hasKey:"key"&array.hasValue:"value"&array.subset:{"other":null})&min:2)';
        $expected = [
            'expression' => '1&((0&0|0)|(1&1&1&1&1)&1)',
            'result'     => true,
        ]; // see below used as PHP code
        $results  = [
            'required' => true,
            'object' => false,
            'object.isInstanceOf:"\\\\Namespace\\\\Class"' => false,
            'object.hasMethod:"getValue"' => false,
            'array' => true,
            'array.isAssociative' => true,
            'array.hasKey:"key"' => true,
            'array.hasValue:"value"' => true,
            'array.subset:{"other":null}' => true,
            'min:2' => true,
        ];

        $this->assertEquals($expected, $this->engine->evaluateExpression($actual, $results));
    }

    public function testEngineEvaluateBitwiseExpressionMethod(): void
    {
        $this->assertFalse($this->engine->evaluateBitwiseExpression('0'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('1'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('~0'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('~1'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('(0)'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('(1)'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('0&0'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('1&0'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('0&1'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('1&1'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('0|0'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('1|0'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('0|1'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('1|1'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('0^0'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('1^0'));
        $this->assertTrue($this->engine->evaluateBitwiseExpression('0^1'));
        $this->assertFalse($this->engine->evaluateBitwiseExpression('1^1'));

        $this->assertEquals(false, $this->engine->evaluateBitwiseExpression('1^1')); // assert memozation
        $this->assertEquals(true, $this->engine->evaluateBitwiseExpression('(1|0)&((~0|0)^0)'));

        // try catch is used to test multiple expceptions at once

        try {
            $this->engine->evaluateBitwiseExpression('   ');
        } catch (InvalidBitwiseExpressionException $error) {
            $this->assertStringContainsString('expression string is empty', $error->getMessage());
        }

        try {
            $this->engine->evaluateBitwiseExpression('1|X');
        } catch (InvalidBitwiseExpressionException $error) {
            $this->assertStringContainsString('contains characters other than ["0", "1", "~", "&", "|", "^", "(", ")"]', $error->getMessage());
        }

        try {
            $this->engine->evaluateBitwiseExpression('^1^0~');
        } catch (InvalidBitwiseExpressionException $error) {
            $this->assertStringContainsString('starts with an operator like ["&", "|", "^"] or ends with an operator like ["~", "&", "|", "^"]', $error->getMessage());
        }

        try {
            $this->engine->evaluateBitwiseExpression('0||0');
        } catch (InvalidBitwiseExpressionException $error) {
            $this->assertStringContainsString('an operator like ["&", "|", "^"] is repeated more than once consecutively', $error->getMessage());
        }

        try {
            $this->engine->evaluateBitwiseExpression('1&(0|1');
        } catch (InvalidBitwiseExpressionException $error) {
            $this->assertStringContainsString('precedence parentheses ["(", ")"] are not balanced', $error->getMessage());
        }

        try {
            $this->engine->evaluateBitwiseExpression('()');
        } catch (InvalidBitwiseExpressionException $error) {
            $this->assertStringContainsString('Infinite loop detected', $error->getMessage());
        }
    }
}

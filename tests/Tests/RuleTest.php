<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests;

use MAKS\Mighty\Rule;
use MAKS\Mighty\Exception\InexecutableRuleException;
use MAKS\Mighty\Exception\InvalidRuleStatementException;
use MAKS\Mighty\Exception\InvalidRuleDefinitionException;
use MAKS\Mighty\TestCase;

class RuleTest extends TestCase
{
    private Rule $rule;


    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new Rule();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->rule);
    }


    public function testRuleObjectDataAccessors(): void
    {
        $this->rule
            ->setName($name = 'return')
            ->setArguments($arguments = ['mixed'])
            ->setCallback($callback = fn ($value) => $value)
            ->setParameters($parameters = ['@input'])
            ->setComparison($comparison = ['@output', '&&', true])
            ->setVariables($variables = ['@label' => 'Data'])
            ->setMessage($message = '${@label} is ${@input}')
            ->setDescription($description = 'Return rule')
            ->setExample($example = 'return:value');

        $this->assertEquals($this->rule->getName(), $name);
        $this->assertEquals($this->rule->getArguments(), $arguments);
        $this->assertEquals($this->rule->getCallback(), $callback);
        $this->assertEquals($this->rule->getParameters(), $parameters);
        $this->assertEquals($this->rule->getComparison(), $comparison);
        $this->assertEquals($this->rule->getVariables(), $variables);
        $this->assertEquals($this->rule->getMessage(), $message);
        $this->assertEquals($this->rule->getDescription(), $description);
        $this->assertEquals($this->rule->getExample(), $example);

        $this->assertEquals($this->rule->getDefinition(), $definition = [
            '@name'        => $name,
            '@arguments'   => $arguments,
            '@callback'    => $callback,
            '@parameters'  => $parameters,
            '@comparison'  => $comparison,
            '@variables'   => $variables,
            '@message'     => $message,
            '@description' => $description,
            '@example'     => $example,
        ]);

        $this->rule->setDefinition($definition);

        $this->rule->name($name);
        $this->rule->arguments($arguments);
        $this->rule->callback($callback);
        $this->rule->parameters($parameters);
        $this->rule->comparison($comparison);
        $this->rule->variables($variables);
        $this->rule->message($message);
        $this->rule->description($description);
        $this->rule->example($example);

        $this->assertEquals($this->rule->name(), $name);
        $this->assertEquals($this->rule->arguments(), $arguments);
        $this->assertEquals($this->rule->callback(), $callback);
        $this->assertEquals($this->rule->parameters(), $parameters);
        $this->assertEquals($this->rule->comparison(), $comparison);
        $this->assertEquals($this->rule->variables(), $variables);
        $this->assertEquals($this->rule->message(), $message);
        $this->assertEquals($this->rule->description(), $description);
        $this->assertEquals($this->rule->example(), $example);
    }

    public function testRuleObjectExecuteMethod(): void
    {
        $this->rule
            ->setName('return')
            ->setArguments(['mixed'])
            ->setCallback(fn ($value) => $value)
            ->setParameters(['@input']);

        $this->rule->setComparison(['@input', '===', true]);
        $this->assertTrue($this->rule->execute(true));

        $this->rule->setComparison(['@input', '!==', false]);
        $this->assertFalse($this->rule->execute(false));

        $this->rule->setComparison(['@input', '==', true]);
        $this->assertTrue($this->rule->execute(1));

        $this->rule->setComparison(['@input', '!=', false]);
        $this->assertFalse($this->rule->execute(0));

        $this->rule->setComparison([]); // this will make the rule return callback result
        $this->assertIsString($this->rule->execute('string'));
    }

    public function testRuleObjectExecuteMethodThrowsAnExceptionIfCallbackExecutionFailed(): void
    {
        $this->rule
            ->name('test.failingRule')
            ->arguments(['string'])
            ->callback(static fn ($input) => unserialize($input)) // this will raise a notice
            ->parameters(['@input'])
            ->comparison(['@output', '!==', '@input'])
            ->example('test.failingRule:"serializedData"')
            ->description('Test rule');

        try {
            ($this->rule)('serializedData');
        } catch (InexecutableRuleException $error) {
            $this->assertStringContainsString('rule execution failed', $error->getMessage());
            $this->assertStringContainsString('unserialize(): Error ', $error->getPrevious()->__toString());
        }
    }

    public function testRuleObjectMagicMethod(): void
    {
        $rule = new Rule(
            [
                '@name'        => 'same',
                '@arguments'   => ['mixed'],
                '@callback'    => fn ($value) => $value,
                '@parameters'  => ['@input'],
                '@comparison'  => ['@input', '===', '@output'],
            ],
            'return:value',
            'value'
        );

        $this->assertEquals('return:value', $rule->__toString());
        $this->assertTrue($rule->__invoke('value'));
    }

    public function testRuleObjectThrowsAnExceptionIfStatementIsInvalid(): void
    {
        $this->expectException(InvalidRuleStatementException::class);
        $this->expectExceptionMessage('Rule statement cannot be an empty string');

        $this->rule->setStatement('');
    }

    public function testRuleObjectThrowsAnExceptionIfDefinitionKeyContainsAnInvalidType(): void
    {
        $this->expectException(InvalidRuleDefinitionException::class);
        $this->expectExceptionMessageMatches('/(The ".+?" definition key must be of type ".+?" got ".+?" instead)/');

        $this->rule->setDefinition([
            '@name' => 'rule',
            '@arguments' => false,
        ]);
    }
}

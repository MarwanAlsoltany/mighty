<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation;

use Throwable;
use Stringable;
use Closure;
use MAKS\Mighty\Engine;
use MAKS\Mighty\Validation\Behavior;
use MAKS\Mighty\Validation\Operator;
use MAKS\Mighty\Exception\InvalidValidationExpressionException;

/**
 * Validation expression builder.
 *
 * Expression Builder implementation for the Mighty Validation Expression Language (mVEL) `v1` (`v1.*.*`).
 *
 * @package Mighty\Validator
 */
class Expression implements Stringable
{
    /**
     * Expression behaviors.
     *
     * @var array<string,Behavior>
     */
    final public const BEHAVIORS = [
        'NORMAL'      => Behavior::Normal,
        'OPTIMISTIC'  => Behavior::Optimistic,
        'PESSIMISTIC' => Behavior::Pessimistic,
    ];

    /**
     * Expression operators.
     *
     * @var array<string,Operator>
     */
    final public const OPERATORS = [
        'NOT'   => Operator::Not,
        'AND'   => Operator::And,
        'OR'    => Operator::Or,
        'XOR'   => Operator::Xor,
        'OPEN'  => Operator::Open,
        'CLOSE' => Operator::Close,
    ];


    /**
     * Expression string buffer.
     *
     * @var string
     */
    protected string $buffer = '';

    /**
     * Expression string buffer tokens.
     *
     * @var array
     */
    protected array $tokens = [];


    /**
     * Returns the current expression string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->build();
    }

    /**
     * Provides rules and aliases as class methods.
     *
     * @param string $name
     * @param mixed[] $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $statement = $this->createRuleStatement($name, $arguments);

        $this->write($statement);

        return $this;
    }


    /**
     * @return array<string,string>
     */
    private function getOperatorChars(): array
    {
        static $operators = null;

        if ($operators === null) {
            $operators = [
                'opening' => implode('', [
                    self::OPERATORS['OPEN']->toScalar(),
                    self::OPERATORS['NOT']->toScalar(),
                ]),
                'closing' => implode('', [
                    self::OPERATORS['CLOSE']->toScalar(),
                ]),
                'combining' => implode('', [
                    self::OPERATORS['AND']->toScalar(),
                    self::OPERATORS['OR']->toScalar(),
                    self::OPERATORS['XOR']->toScalar(),
                ]),
                'all' => implode('', Operator::values()),
            ];
        }

        return $operators;
    }

    /**
     * @return string
     */
    private function getBehaviorChars(): string
    {
        static $behaviors = null;

        if ($behaviors === null) {
            $behaviors = implode('', Behavior::values());
        }

        return $behaviors;
    }

    /**
     * Writes the passed string to the current expression string buffer.
     * Note that the necessary operators will NOT be added automatically (use `self::write()` instead).
     * Note that this method may make the expression fail when build if it is malformed.
     *
     * @param string $string Rule, rule statement, rule alias, rule macro, an operator, a variable, a comment, or any arbitrary string.
     *
     * @return static
     */
    public function concat(string $string): static
    {
        $this->buffer  .= $string;
        $this->tokens[] = $string;

        return $this;
    }

    /**
     * Writes the passed string to the current expression string buffer.
     * Note that the necessary operators will be added automatically.
     *
     * @param string $string Rule, rule statement, rule alias, rule macro or an operator.
     *
     * @return static
     */
    public function write(string $string): static
    {
        $operators = $this->getOperatorChars();
        $current   = trim($string);
        $last      = strval(substr($buffer = trim($this->buffer), -1));

        if (strlen($buffer) > 0 && (
            // (1) if the current string is not an operator "~&|^()"
            strpos($operators['all'], $current) === false &&
            // (1) and the last character is not an operator "~&|^()"
            strpos($operators['all'], $last) === false ||
            // (2) or the current string is an opening operator "~("
            strpos($operators['opening'], $current) !== false &&
            // (2) and the last character is not a combining operator "&|^"
            strpos($operators['combining'], $last) === false ||
            // (3) or the last character is a closing operator ")"
            strpos($operators['closing'], $last) !== false &&
            // (3) and the current string is not an operator "~&|^()"
            strpos($operators['all'], $current) === false
        )) {
            $this->buffer  .= $operator = self::OPERATORS['AND']->toScalar();
            $this->tokens[] = $operator;
        }

        return $this->concat($current);
    }

    /**
     * Makes the expression normal (executes all checks). The is the default behavior.
     *
     * NOTE: Use this to remove an already added behavior.
     *
     * @return static
     */
    public function normal(): static
    {
        $behaviors = $this->getBehaviorChars();
        $behavior  = $this->buffer[0] ?? '*';

        if (strpos($behaviors, $behavior) === 0) {
            $this->buffer = substr($this->buffer, 1) ?: '';
            $this->tokens = [-1 => ''] + $this->tokens;
        }

        return $this;
    }

    /**
     * Makes the expression optimistic (stop checking after first success).
     *
     * NOTE: This has effect only if the expression is not already `PESSIMISTIC`.
     *
     * NOTE: Be careful when using `OPTIMISTIC` with `AND` or `XOR`.
     *
     * @return static
     */
    public function optimistic(): static
    {
        $behaviors = $this->getBehaviorChars();
        $behavior  = $this->buffer[0] ?? '*';

        if (strpos($behaviors, $behavior) === false) {
            $this->buffer = ($behavior = Behavior::Optimistic->value) . $this->buffer;
            $this->tokens = [-1 => $behavior] + $this->tokens;
        }

        return $this;
    }

    /**
     * Makes the expression pessimistic (stop checking after first failure).
     *
     * NOTE: This has effect only if the expression is not already `PESSIMISTIC`.
     *
     * NOTE: Be careful when using `PESSIMISTIC` with `OR` or `XOR`.
     *
     * @return static
     */
    public function pessimistic(): static
    {
        $behaviors = $this->getBehaviorChars();
        $behavior  = $this->buffer[0] ?? '*';

        if (strpos($behaviors, $behavior) === false) {
            $this->buffer = ($behavior = Behavior::Pessimistic->value) . $this->buffer;
            $this->tokens = [-1 => $behavior] + $this->tokens;
        }

        return $this;
    }

    /**
     * Adds NOT operator (tilde: `~`). Negates the next rule/group.
     *
     * @return static
     */
    public function not(): static
    {
        $this->write(self::OPERATORS['NOT']->value);

        return $this;
    }

    /**
     * Adds AND operator (ampersand: `&`) (default). Ands the next rule/group.
     *
     * @return static
     */
    public function and(): static
    {
        $this->write(self::OPERATORS['AND']->value);

        return $this;
    }

    /**
     * Adds OR operator (pipe: `|`). Ors the next rule/group.
     *
     * @return static
     */
    public function or(): static
    {
        $this->write(self::OPERATORS['OR']->value);

        return $this;
    }

    /**
     * Adds XOR operator (caret: `^`). Xors the next rule/group.
     *
     * @return static
     */
    public function xor(): static
    {
        $this->write(self::OPERATORS['XOR']->value);

        return $this;
    }

    /**
     * Adds OPEN operator (opening parenthesis: `(`). Starts a new group.
     *
     * @return static
     */
    public function open(): static
    {
        $this->write(self::OPERATORS['OPEN']->value);

        return $this;
    }

    /**
     * Adds CLOSE operator (closing parenthesis: `)`). Ends the current group.
     *
     * @return static
     */
    public function close(): static
    {
        $this->write(self::OPERATORS['CLOSE']->value);

        return $this;
    }

    /**
     * Writes a rule to the current expression string.
     *
     * @param string $rule Rule statement (or rule alias).
     *
     * @return static
     */
    public function rule(string $rule): static
    {
        $this->write($rule);

        return $this;
    }

    /**
     * Writes a macro to the current expression string.
     *
     * @param string $macro Macro name (without `[]`).
     *
     * @return static
     */
    public function macro(string $macro): static
    {
        $macro = sprintf('[%s]', trim($macro, '[ ]'));

        $this->write($macro);

        return $this;
    }

    /**
     * Groups a set of rules inside a pair of parentheses `()`.
     *
     * @param callable $callback The callback that will be called to build the group.
     *      The callback will be bound to the current instance and/or receive it as the first parameter if can't be bound.
     *
     * @return static
     */
    public function group(callable $callback): static
    {
        $this->open();

        try {
            Closure::fromCallable($callback)->bindTo($this)($this);
        } catch (Throwable) {
            $callback($this);
        }

        $this->close();

        return $this;
    }

    /**
     * Returns a the passed key as a valid back-reference injectable.
     *
     * @param string $key Variable key (without `${}`).
     *
     * @return string A valid back-reference or an empty string if the passed parameter was empty.
     *
     * NOTE: This method returns the passed key as a valid back-reference (`${key}`) only,
     * and NOT the actual value of the variable and does NOT add it to the buffer.
     */
    public static function variable(string $key): string
    {
        $variable = trim($key, '${ }');
        $variable = sprintf('${%s}', $variable);
        $variable = $variable === '${}' ? '' : $variable;

        return $variable;
    }

    /**
     * Returns a the passed string as a valid comment.
     *
     * @param string $text Comment text.
     *
     * @return string A valid comment or an empty string if the passed parameter was empty.
     *
     * NOTE: This method returns the passed string as a valid comment (`∕*text*∕`) only,
     * and does NOT add it to the buffer, use `self::concat()` to add it.
     */
    public static function comment(string $text): string
    {
        $comment = trim($text, '/ *');
        $comment = str_word_count($comment) > 1 ? " {$comment} " : $comment;
        $comment = sprintf('/*%s*/', $comment);
        $comment = $comment === '/**/' ? '' : $comment;

        return $comment;
    }

    /**
     * Returns the current expression string.
     *
     * @return string
     *
     * @throws InvalidValidationExpressionException If the expression string is invalid.
     */
    public function build(): string
    {
        $expression = $this->buffer;

        $checks = [
            'no rules were added (expression string is empty)' =>
                preg_match('/^$/S', $expression) === 1,
            'starts with an operator like ["&", "|", "^"] or ends with an operator like ["~", "&", "|", "^"]' =>
                preg_match('/(?:^[&|^])|(?:[~&|^]$)/S', $expression) === 1,
            'an operator like ["&", "|", "^"] is repeated more than once consecutively' =>
                preg_match('/(?:[&|^]{2,})/S', $expression) === 1,
            'precedence parentheses ["(", ")"] are not balanced' =>
                preg_match('/(?:[\(\)])/S', $expression) === 1 && substr_count($expression, '(') !== substr_count($expression, ')'),
        ];

        if (in_array(true, $checks, true)) {
            $problems = implode(', ', array_keys(array_filter($checks)));

            throw new InvalidValidationExpressionException(
                "Invalid validation expression: '{$expression}'. Problem(s): {$problems}"
            );
        }

        return $expression;
    }

    /**
     * Returns a valid rule statement from the passed name and arguments.
     *
     * @param string $name Rule name, preferably in camelCase.
     * @param mixed[] $arguments Rule arguments.
     *
     * @return string The rule statement.
     *
     * @abstract Reimplements to change the way rules are built.
     */
    protected function createRuleStatement(string $name, array $arguments): string
    {
        $name      = Engine::createRuleName($name);
        $arguments = Engine::createRuleArguments($arguments);
        $statement = Engine::createRuleStatement($name, $arguments);

        return $statement;
    }
}

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Rule;

use MAKS\Mighty\Support\Inspector;
use MAKS\Mighty\Support\Utility;
use MAKS\Mighty\Exception\InvalidRuleDefinitionException;

/**
 * Rule definition class.
 *
 * @package Mighty
 */
abstract class Definition
{
    /**
     * Rule definition schema/structure.
     *
     * NOTE: All words prefixed with the `@` symbol are variables specific to the rule definition.
     *
     * - `@rule`: (object) [magic] The rule object.
     *      This value is a magic value and is not required inside rule definition array.
     *      It is used to retrieve the rule object. Useful for getting/setting some data of
     *      the rule object like the statement or any other attribute inside the callback if needed.
     *
     * - `@name`: (string) [required] Rule name.
     *      This value can be any string consisting of alphanumeric characters, dots, dashes, underscores
     *      (matches: `/^[A-Za-z0-9_\-\.]+$/`), and between 2 and 255 characters.
     *
     * - `@arguments`: (array|null) [optional] Rule arguments.
     *      If empty, this means that the rule accepts no arguments. Otherwise, it denotes the data types of the arguments.
     *      This value serves two roles, at parsing time it will be used to set arguments data types,
     *      later on it will be filled with the actual values in their expected data types.
     *      Valid data types casts are: `null`, `boolean` or `bool`, `integer` or `int`, `float` or `double`,
     *      `string`, `array`, and `object`. All data types must be stringified using JSON Spec rules and when supplied,
     *      some extra care needs to be taken (especially with `array` and `object`), the JSON needs to be escaped by
     *      wrapping it as a whole with`'` (single quotes) and escaping any single quotes inside the JSON
     *      with `\` (backslash) —using `addcslashes($json, "'")`— to avoid CSV collisions when parsing.
     *      Arguments can also be variadic by prefixing them with `...` (i.e `'...string'`).
     *      Note that only the last argument can be variadic, if an argument is variadic and is not the last,
     *      all extra arguments will be packed into the resulting array starting from the variadic position.
     *
     * - `@callback`: (callable|null) [optional] Rule callback function.
     *      This is where the logic of the rule lives.
     *      The callback should validate, sanitize, or check the input and return some value.
     *      If empty, the input value will be simply returned as is (fallback: `fn ($input) => $input`).
     *
     * - `@parameters`: (array|null) [optional] Rule callback parameters.
     *      Normally this should look something like `['@input']` (fallback: `['@input']`).
     *      More parameters can be added depending on callback function requirements.
     *      The position of the `@input` depends on the callback function (can be first or any other position).
     *      Note that the `@input` will be injected when the rule is executed.
     *      This value has access to the `@rule`, `@name`, `@input`, and `@arguments` injectables.
     *      Nested data can be accessed using dot notation `@injectable.someKey` or `@injectable.0` (with numeric arrays).
     *      Fallbacks can also be specified using the syntax `@injectable.someKey:fallback` (fallbacks must be scalar).
     *
     * - `@input`: (mixed) [magic] Rule input.
     *      This value is a magic value and is not required inside rule definition array.
     *      It references the input value that was provided to the rule when executed.
     *
     * - `@output`: (mixed) [magic] Rule callback output.
     *      This value is a magic value and is not required inside rule definition array.
     *      It references the output resulting from executing rule callback on rule input (fallback: `@input`, see `@callback`).
     *
     * - `@comparison`: (array|null) [optional] Rule comparison.
     *      This is used to compare the rule's callback result against any currently available data.
     *      Normally this should look something like `['@output', '!==', false]`
     *      (fallback: `['@output', '&&', true]`, returns truthiness of the result).
     *      This value has access to the `@rule`, `@name`, `@input`, `@arguments`, `@callback`, `@parameters`, and `@output` injectables.
     *      Nested data can be accessed using dot notation `@injectable.someKey` or `@injectable.0` (with numeric arrays).
     *      Fallbacks can also be specified using the syntax `@injectable.someKey:fallback` (fallbacks must be scalar).
     *      All PHP logical and bitwise operators are available with the same syntax (but of course as strings), namely:
     *      (L) Logical: `!` or `not`; `==` or `eq`; `!=` or `<>` or `neq`; `===` or `id`; `!==` or `nid`;
     *      `<` or `lt`; `<=` or `lte`; `>` or `gt`; `>=` or `gte`; `&&` or `and`; `||` or `or`; `xor`.
     *      (B) Bitwise: `~`; `&`; `|`; `^`; `<<`; `>>`. If an invalid operator is specified, `&&` will be used instead.
     *
     * - `@message`: (string|null) [optional] Rule message.
     *      This value is optional and is used during validation to provide feedback to the user in case of failure.
     *      This value has access to the `@input`, `@output`, `@arguments`, `@parameters`, `@label` and `@extra` injectables.
     *      Nested data can be accessed using dot notation `@injectable.someKey` or `@injectable.0` (with numeric arrays).
     *      Fallbacks can also be specified using the syntax `@injectable.0:fallback` (fallbacks must be scalar).
     *      Note that injectables in messages have to be wrapped with `{}` (i.e. `${@injectable:fallback}`) as placeholder.
     *
     * - `@variables`: (array|null) [magic|optional] Rule variables.
     *      This value is a magic/optional and is not required inside rule definition array.
     *      It is an associative array that holds injectables that can be used to inject some variables into `@message` placeholders.
     *      It contains the variables `@input`, `@output`, `@arguments`, `@parameters`, `@label`, and `@extra` after executing the rule.
     *      The `@label` injectable, is a special injectable that should be overwritten by the validator that executed the rule,
     *      it serves as a label for the message to provide more friendly and specific error messages (fallback: `The field`).
     *      The `@variables` may also sometimes contain the `@extra` variable, this injectable is also a special injectable that contains
     *      some extra variables that the `@callback` may want to make available to the `@message` (this is a convention and is not a hard rule).
     *      If the `@variables` is provided in the definition, it will be merged with rule variables after the execution.
     *      Note that variables (with the same keys) resulting from executing the rule will overwrite the ones provided in the definition.
     *
     * - `@description`: (string|null) [optional] Rule description.
     *      This value is optional and has no purpose other than to provide a description for the rule.
     *
     * - `@example`: (string|null) [optional] Rule example.
     *      This value is optional and has no purpose other than to provide an example of how to use the rule.
     *
     * @var array<string,null|string|array<mixed>|callable>
     *
     * @example
     */
    final public const SCHEMA = [
        '@name'        => 'equals',
        '@arguments'   => ['string'],
        '@callback'    => [Inspector::class, 'isEqual'],
        '@parameters'  => ['@input', '@arguments.0'],
        '@comparison'  => ['@output', '===', true],
        '@variables'   => ['@label' => 'The field', '@extra' => []],
        '@message'     => '${@label} must be equal to ${@arguments.0}.',
        '@description' => 'This rule compares the input against the specified value using the "==" operator.',
        '@example'     => 'equals:var',
    ];

    /**
     * Rule definition array defaults.
     *
     * @var array<string,null|string|array<mixed>|callable>
     */
    protected const DEFAULT = [
        '@name'        => 'rule',
        '@arguments'   => [],
        '@callback'    => [Inspector::class, 'return'],
        '@parameters'  => ['@input'],
        '@comparison'  => ['@output', '&&', true],
        '@variables'   => ['@label' => 'The field', '@extra' => []],
        '@message'     => '${@label} is invalid!',
        '@description' => null,
        '@example'     => null,
    ];


    /**
     * Rule definition array.
     *
     * @var array<string,null|string|array<mixed>|callable>
     */
    protected array $definition = self::DEFAULT;


    /**
     * Asserts that the rule definition is valid.
     *
     * @param array<string,mixed> $definition The rule definition.
     *
     * @return void
     *
     * @throws InvalidRuleDefinitionException If the rule definition is invalid.
     */
    protected function assertDefinitionIsValid(array $definition): void
    {
        $validations = [
            // attribute   => type
            '@name'        => 'string',
            '@arguments'   => 'array',
            '@callback'    => 'callable',
            '@parameters'  => 'array',
            '@comparison'  => 'array',
            '@variables'   => 'array|null',
            '@message'     => 'string',
            '@description' => 'string|null',
            '@example'     => 'string|null',
        ];

        foreach ($validations as $key => $types) {
            $value = $definition[$key] ?? null;
            $types = explode('|', $types);
            $type  = strtolower(gettype($value));

            if (!in_array($type, $types)) {
                // callables can also be strings or arrays
                if ($key === '@callback' && is_callable($value)) {
                    continue;
                }

                $types = implode(', ', $types);

                throw new InvalidRuleDefinitionException(
                    Utility::interpolate(
                        'The "{key}" definition key must be of type "{types}" got "{type}" instead. ' .
                        'Refer to {class}::SCHEMA for more information about the accepted data-types',
                        ['key' => $key, 'types' => $types, 'type' => $type, 'class' => static::class]
                    )
                );
            }
        }
    }

    /**
     * Gets rule definition array.
     *
     * @return array
     */
    public function getDefinition(): array
    {
        return $this->definition;
    }

    /**
     * Sets rule definition array.
     *
     * @param array<string,mixed> $definition Rule definition array.
     *
     * @return static
     *
     * @throws InvalidRuleDefinitionException If the rule definition is invalid.
     */
    public function setDefinition(array $definition): static
    {
        // to allow for setting only a subset
        $definition = array_replace($this->definition, array_filter($definition, fn ($value) => $value !== null));

        $this->assertDefinitionIsValid($definition);

        $this->definition = $definition;

        return $this;
    }

    /**
     * Gets the name of the rule.
     */
    public function getName(): string
    {
        return $this->definition['@name'];
    }

    /**
     * Sets the name of the rule.
     *
     * @param string $name The name of the rule.
     *
     * @return static
     */
    public function setName(string $name): static
    {
        $this->definition['@name'] = $name;

        return $this;
    }

    /**
     * Gets the arguments of the rule.
     *
     * @return array<mixed>
     */
    public function getArguments(): array
    {
        return $this->definition['@arguments'];
    }

    /**
     * Gets the arguments of the rule.
     *
     * @param array<string> $arguments The arguments of the rule.
     *
     * @return static
     */
    public function setArguments(array $arguments): static
    {
        $this->definition['@arguments'] = $arguments;

        return $this;
    }

    /**
     * Gets the callback of the rule.
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->definition['@callback'];
    }

    /**
     * Sets the callback of the rule.
     *
     * @param callable $callback The callback of the rule.
     *
     * @return static
     */
    public function setCallback(callable $callback): static
    {
        $this->definition['@callback'] = $callback;

        return $this;
    }

    /**
     * Gets the parameters of the rule.
     *
     * @return array<mixed>
     */
    public function getParameters(): array
    {
        return $this->definition['@parameters'];
    }

    /**
     * Sets the parameters of the rule.
     *
     * @param array<mixed> $parameters The parameters of the rule.
     *
     * @return static
     */
    public function setParameters(array $parameters): static
    {
        $this->definition['@parameters'] = $parameters;

        return $this;
    }

    /**
     * Gets the comparison of the rule.
     *
     * @return array<mixed>
     */
    public function getComparison(): array
    {
        return $this->definition['@comparison'];
    }

    /**
     * Sets the comparison of the rule.
     *
     * @param array<mixed> $comparison The comparison of the rule.
     *
     * @return static
     */
    public function setComparison(array $comparison): static
    {
        $this->definition['@comparison'] = $comparison;

        return $this;
    }

    /**
     * Gets the variables of the rule.
     *
     * @return null|array<string,mixed>
     */
    public function getVariables(): ?array
    {
        return $this->definition['@variables'];
    }

    /**
     * Sets the variables of the rule.
     *
     * @param null|array<string,mixed> $variables The variables of the rule.
     *
     * @return static
     */
    public function setVariables(?array $variables): static
    {
        $this->definition['@variables'] = $variables;

        return $this;
    }

    /**
     * Gets the message of the rule.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->definition['@message'];
    }

    /**
     * Sets the message of the rule.
     *
     * @param string $message The message of the rule.
     *
     * @return static
     */
    public function setMessage(string $message): static
    {
        $this->definition['@message'] = $message;

        return $this;
    }

    /**
     * Gets the description of the rule.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->definition['@description'];
    }

    /**
     * Sets the description of the rule.
     *
     * @param string $description The description of the rule.
     *
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->definition['@description'] = $description;

        return $this;
    }

    /**
     * Gets the example of the rule.
     *
     * @return string|null
     */
    public function getExample(): ?string
    {
        return $this->definition['@example'];
    }

    /**
     * Sets the example of the rule.
     *
     * @param string $example The example of the rule.
     *
     * @return static
     */
    public function setExample(string $example): static
    {
        $this->definition['@example'] = $example;

        return $this;
    }

    /**
     * Sets the name of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param string|false $name The name of the rule.
     *
     * @return string|static
     */
    public function name(string|false $name = false): string|static
    {
        if ($name === false) {
            return $this->getName();
        }

        return $this->setName($name);
    }

    /**
     * Sets the arguments of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param array<mixed>|false $arguments The arguments of the rule.
     *
     * @return array<mixed>|static
     */
    public function arguments(array|false $arguments = false): array|static
    {
        if ($arguments === false) {
            return $this->getArguments();
        }

        return $this->setArguments($arguments);
    }

    /**
     * Sets the callback of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param callable|false $callback The callback of the rule.
     *
     * @return callable|static
     */
    public function callback(callable|false $callback = false): callable|static
    {
        if ($callback === false) {
            return $this->getCallback();
        }

        return $this->setCallback($callback);
    }

    /**
     * Sets the parameters of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param array<mixed>|false $parameters The parameters of the rule.
     *
     * @return array<mixed>|static
     */
    public function parameters(array|false $parameters = false): array|static
    {
        if ($parameters === false) {
            return $this->getParameters();
        }

        return $this->setParameters($parameters);
    }

    /**
     * Sets the comparison of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param array<mixed>|false $comparison The comparison of the rule.
     *
     * @return array<mixed>|static
     */
    public function comparison(array|false $comparison = false): array|static
    {
        if ($comparison === false) {
            return $this->getComparison();
        }

        return $this->setComparison($comparison);
    }

    /**
     * Sets the variables of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param null|array<string,mixed>|false $variables The variables of the rule.
     *
     * @return null|array<string,mixed>|static
     */
    public function variables(null|array|false $variables = false): null|array|static
    {
        if ($variables === false) {
            return $this->getVariables();
        }

        return $this->setVariables($variables);
    }

    /**
     * Sets the message of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param string|false $message The message of the rule.
     *
     * @return string|static
     */
    public function message(string|false $message = false): string|static
    {
        if ($message === false) {
            return $this->getMessage();
        }

        return $this->setMessage($message);
    }

    /**
     * Sets the description of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param string|false $description The description of the rule.
     *
     * @return null|string|static
     */
    public function description(string|false $description = false): null|string|static
    {
        if ($description === false) {
            return $this->getDescription();
        }

        return $this->setDescription($description);
    }

    /**
     * Sets the example of the rule (returns object), or gets it if parameter is `false` or not specified.
     *
     * @param string|false $example The example of the rule.
     *
     * @return null|string|static
     */
    public function example(string|false $example = false): null|string|static
    {
        if ($example === false) {
            return $this->getExample();
        }

        return $this->setExample($example);
    }
}

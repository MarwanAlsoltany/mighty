<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty;

use Closure;
use MAKS\Mighty\Validator;
use MAKS\Mighty\Rule;
use MAKS\Mighty\Engine;
use MAKS\Mighty\Support\Utility;
use MAKS\Mighty\Validation\Expression;
use MAKS\Mighty\Exception\ValidationLogicException;

/**
 * Validator aware validation expression builder.
 *
 * {@inheritDoc}
 *
 * Example:
 * ```
 * $validation = (new Validation())->required()->string()->between(2, 255)->or()->null();
 *
 * $validation = Validation::required()->string()->between(2, 255)->or()->null()->build();
 * ```
 *
 * @package Mighty\Validator
 */
class Validation extends Expression
{
    /**
     * Associated Validator instance.
     *
     * @var Validator|null
     */
    protected readonly ?Validator $validator;


    /**
     * Validation constructor.
     *
     * @param Validator|null $validator [optional] The validator instance, used to retrieve available rules from.
     *      If not specified, rule name guessing as per convention will be used instead.
     */
    public function __construct(?Validator $validator = null)
    {
        $this->validator = $validator;
    }

    /**
     * Provides rules and aliases as static class methods.
     *
     * @param string $name
     * @param mixed[] $arguments
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return static::new()->{$name}(...$arguments);
    }

    /**
     * Creates a new Validation instance that is bound to the default Validator.
     *
     * @return self
     */
    public static function new(): self
    {
        static $validator = new Validator();

        return new Validation($validator);
    }


    /**
     * Adds a validation string or object as a group to the current validation expression.
     *
     * @param string|Expression $validation Validation expression string or object.
     *
     * @return static
     */
    public function add(string|Expression $validation): static
    {
        // make sure the added expression has no behavior
        $expression = (new parent())
            ->write((string)$validation)
            ->normal()
            ->build();

        $this->open();
        $this->write($expression);
        $this->close();

        return $this;
    }

    /**
     * Writes a rule to the current validation expression that executes the passed callback.
     *
     * @param callable $callback The callback to execute.
     *      The callback will be passed the current input as the first parameter and
     *      the rule object as the second parameter. It must return a boolean as result.
     * @param string|null $id [optional] The callback id.
     *      The name (or a unique ID if not specified) will be prefixed with `callback.`
     *      to allow the possibility of providing a message for the callback on the Validator instance.
     *
     * @return static
     *
     * @throws ValidationLogicException If the `Validation::class` instance is not bound to a `Validator::class` instance.
     */
    public function callback(callable $callback, ?string $id = null): static
    {
        if ($this->validator === null) {
            throw new ValidationLogicException(
                Utility::interpolate(
                    'Cannot use a callback rule in a {validation} instance that is not bound to an instance of {validator}',
                    ['validation' => static::class, 'validator' => Validator::class]
                )
            );
        }

        $callback = $callback instanceof Closure ? $callback : Closure::fromCallable($callback);
        $id       = $id ?: md5(spl_object_hash($callback));
        $name     = sprintf('callback.%s', $id);

        $rule = (new Rule())
            ->name($name)
            ->callback($callback)
            ->parameters(['@input', '@rule']);

        $this->validator->addRule($rule);

        $this->write($name);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function createRuleStatement(string $name, array $arguments): string
    {
        $hash  = $this->getHashedName($name);
        $names = $this->getHashedNames();

        if (!isset($names[$hash])) {
            return parent::createRuleStatement($name, $arguments);
        }

        $name      = $names[$hash];
        $arguments = Engine::createRuleArguments($arguments);
        $statement = Engine::createRuleStatement($name, $arguments);

        return $statement;
    }

    /**
     * Returns a consistent hash for the rule name.
     *
     * @param string $name Rule name.
     *
     * @return string
     */
    private function getHashedName(string $name): string
    {
        return md5(Utility::transform($name, 'alnum', 'lower', 'spaceless'));
    }

    /**
     * Returns an associative array of rule names and their corresponding hashes.
     *
     * @return array<string,string>
     */
    private function getHashedNames(): array
    {
        if (!($this->validator instanceof Validator)) {
            return [];
        }

        // as this operation is expensive, the hash table is cached
        // and is created only once for each validator rules set

        /** @var array<string,array<string,string>> $cache */
        static $cache = [];

        $rules   = $this->validator->getRules();
        $aliases = $this->validator->getAliases();

        // rules/aliases are also the key for each element
        $rules   = array_keys($rules);
        $aliases = array_keys($aliases);
        $checks  = array_merge($rules, $aliases);
        // sort rules names to make cache key consistent
        sort($checks, SORT_STRING);

        // generate cache key for the hash table
        $key = md5(implode('+', $checks));

        // if cache is not yet created, create it
        if (!isset($cache[$key])) {
            $hash = [$this, 'getHashedName'];

            $checks = array_combine($checks, $checks);
            $checks = array_map($hash, $checks);
            $checks = array_flip($checks);

            $cache[$key] = $checks;
        }

        return $cache[$key];
    }
}

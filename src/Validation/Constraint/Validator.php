<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Constraint;

use Reflector;
use Reflection;
use ReflectionObject;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionProperty;
use ReflectionMethod;
use ReflectionAttribute;
use MAKS\Mighty\Result;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint\ValidatesOne;
use MAKS\Mighty\Validation\Constraint\ValidatesMany;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectInterface;
use MAKS\Mighty\Exception\ValidatorThrowable;
use MAKS\Mighty\Exception\ValidationLogicException;
use MAKS\Mighty\Exception\ValidationFailedException;
use MAKS\Mighty\Support\Utility;

/**
 * Validatable object constraints validator.
 *
 * @package Mighty\Validator
 */
class Validator
{
    private const CLASS_ATTRIBUTE    = 'class';
    private const CONSTANT_ATTRIBUTE = 'constant';
    private const PROPERTY_ATTRIBUTE = 'property';
    private const METHOD_ATTRIBUTE   = 'method';


    /**
     * Validatable objects reflections cache.
     *
     * @var array<string,Reflector|Reflector[]>
     */
    protected static array $reflections;


    /**
     * Validatable object constraints.
     *
     * @var array<string,Constraint>
     */
    protected array $constraints;

    /**
     * Validatable object validation results.
     *
     * @var array<string,Result>
     */
    protected array $results;

    /**
     * Validatable object validation errors.
     *
     * @var array<string,Result>
     */
    protected array $errors;


    /**
     * Validator constructor.
     *
     * @param ValidatableObjectInterface $object
     */
    public function __construct(
        protected ValidatableObjectInterface $object,
    ) {
        $this->constraints = [];
        $this->results     = [];
        $this->errors      = [];
    }


    /**
     * Checks object constraints and throws an exception if validation failed.
     *
     * @return void
     *
     * @throws ValidationFailedException If any constraint failed.
     * @throws ValidationLogicException If validation for a method with required parameters is attempted.
     */
    public function check(): void
    {
        $targetRefKey = $this->getMemoizationKey(ReflectionObject::class);

        /** @var ReflectionClass $reflection */
        $reflection = static::$reflections[$targetRefKey] ??= new ReflectionObject($this->object);

        $this->validateClass($reflection);
        $this->validateConstants($reflection);
        $this->validateProperties($reflection);
        $this->validateMethods($reflection);

        if (!empty($errors = $this->getErrors())) {
            $this->fail(...$errors);
        }
    }

    /**
     * Validates object constraints and returns validation results.
     *
     * @return array<string,Result>
     */
    public function validate(): array
    {
        $targetRefKey = $this->getMemoizationKey(ReflectionObject::class);

        /** @var ReflectionClass $reflection */
        $reflection = static::$reflections[$targetRefKey] ??= new ReflectionObject($this->object);

        $check = 0;

        while (($check = ++$check) <= 4) {
            try {
                match ($check) {
                    1 => $this->validateClass($reflection),
                    2 => $this->validateConstants($reflection),
                    3 => $this->validateProperties($reflection),
                    4 => $this->validateMethods($reflection),
                };
            } catch (ValidatorThrowable) {
                // these are exception thrown by
                // Constraints with Strategy::FailFast
                // they are ignored to collect all results
            }
        }

        return $this->getResults();
    }

    /**
     * Returns object constraints validation results.
     *
     * @return array<string,Result>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * Returns object constraints validation errors.
     *
     * @return array<string,Result>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    /**
     * Validates class attributes of the passed validatable object reflection.
     *
     * @param ReflectionClass $reflection The reflection on the validatable object.
     *
     * @return void
     *
     * @throws ValidationFailedException If a constraint with `Strategy::FailFast` failed.
     */
    protected function validateClass(ReflectionClass $reflection): void
    {
        $attrRefKey = $this->getMemoizationKey(ReflectionAttribute::class, self::CLASS_ATTRIBUTE);

        /** @var ReflectionAttribute[] $attributes */
        $attributes = static::$reflections[$attrRefKey] ??= $reflection->getAttributes(
            Constraint::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (empty($attributes)) {
            return;
        }

        $name  = $reflection->getName();
        $value = $this->object;

        $this->checkAttributes($attributes, self::CLASS_ATTRIBUTE, $name, $value, $attrRefKey);
    }

    /**
     * Validates constants attributes of the passed validatable object reflection.
     *
     * @param ReflectionClass $reflection The reflection on the validatable object.
     *
     * @return void
     *
     * @throws ValidationFailedException If a constraint with `Strategy::FailFast` failed.
     */
    protected function validateConstants(ReflectionClass $reflection): void
    {
        $targetRefKey = $this->getMemoizationKey(ReflectionClassConstant::class);

        /** @var ReflectionClassConstant[] $constants */
        $constants    = static::$reflections[$targetRefKey] ??= $reflection->getReflectionConstants();

        foreach ($constants as $constant) {
            $target = $constant->getName();
            $prefix = '::';
            $suffix = '';

            $attrRefKey = $this->getMemoizationKey(ReflectionAttribute::class, $target, $prefix, $suffix);

            /** @var ReflectionAttribute[] $attributes */
            $attributes = static::$reflections[$attrRefKey] ??= $constant->getAttributes(
                Constraint::class,
                ReflectionAttribute::IS_INSTANCEOF
            );

            if (empty($attributes)) {
                continue;
            }

            $name  = $constant->getDeclaringClass()->getName() . $prefix . $target . $suffix;
            $value = $constant->getValue();

            $this->checkAttributes($attributes, self::CONSTANT_ATTRIBUTE, $name, $value, $attrRefKey);
        }
    }

    /**
     * Validates properties attributes of the passed validatable object reflection.
     *
     * @param ReflectionClass $reflection The reflection on the validatable object.
     *
     * @return void
     *
     * @throws ValidationFailedException If a constraint with `Strategy::FailFast` failed.
     */
    protected function validateProperties(ReflectionClass $reflection): void
    {
        $targetRefKey = $this->getMemoizationKey(ReflectionProperty::class);

        /** @var ReflectionProperty[] $properties */
        $properties = static::$reflections[$targetRefKey] ??= $reflection->getProperties();

        foreach ($properties as $property) {
            $target = $property->getName();
            $prefix = $property->isStatic() ? '::$' : '->';
            $suffix = '';

            $attrRefKey = $this->getMemoizationKey(ReflectionAttribute::class, $target, $prefix, $suffix);

            /** @var ReflectionAttribute[] $attributes */
            $attributes = static::$reflections[$attrRefKey] ??= $property->getAttributes(
                Constraint::class,
                ReflectionAttribute::IS_INSTANCEOF
            );

            if (empty($attributes)) {
                continue;
            }

            $name  = $property->getDeclaringClass()->getName() . $prefix . $target . $suffix;
            $value = $property->getValue($this->object);

            $this->checkAttributes($attributes, self::PROPERTY_ATTRIBUTE, $name, $value, $attrRefKey);
        }
    }

    /**
     * Validates methods attributes of the passed validatable object reflection.
     *
     * @param ReflectionClass $reflection The reflection on the validatable object.
     *
     * @return void
     *
     * @throws ValidationFailedException If a constraint with `Strategy::FailFast` failed.
     * @throws ValidationLogicException If validation for a method with required parameters is attempted.
     */
    protected function validateMethods(ReflectionClass $reflection): void
    {
        $targetRefKey = $this->getMemoizationKey(ReflectionMethod::class);

        /** @var ReflectionMethod[] $methods */
        $methods = static::$reflections[$targetRefKey] ??= $reflection->getMethods();

        foreach ($methods as $method) {
            $target = $method->getName();
            $prefix = $method->isStatic() ? '::' : '->';
            $suffix = '()';

            $attrRefKey = $this->getMemoizationKey(ReflectionAttribute::class, $target, $prefix, $suffix);

            /** @var ReflectionAttribute[] $attributes */
            $attributes = static::$reflections[$attrRefKey] ??= $method->getAttributes(
                Constraint::class,
                ReflectionAttribute::IS_INSTANCEOF
            );

            if (empty($attributes)) {
                continue;
            }

            if ($args = $method->getNumberOfRequiredParameters()) {
                $name = $method->class . $prefix . $target . $suffix;

                throw new ValidationLogicException(
                    Utility::interpolate(
                        'Cannot validate methods that have required parameters. {name} has {args} required parameter(s).',
                        compact('name', 'args')
                    )
                );
            }

            $name  = $method->getDeclaringClass()->getName() . $prefix . $target . $suffix;
            $value = $method->invoke($this->object);

            $this->checkAttributes($attributes, self::METHOD_ATTRIBUTE, $name, $value, $attrRefKey);
        }
    }

    /**
     * Checks attributes of the passed validatable object reflection.
     *
     * @param ReflectionAttribute[] $attributes the reflection on the validatable object attributes.
     * @param string $type The type of the attribute.
     * @param string $name The name of the field.
     * @param mixed $value The value of the field.
     * @param string $cacheKey The cache of the object.
     *
     * @return void
     *
     * @throws ValidationFailedException If a constraint with `Strategy::FailFast` failed.
     */
    protected function checkAttributes(array $attributes, string $type, string $name, mixed $value, ?string $cacheKey = null): void
    {
        foreach ($attributes as $attribute) {
            $key        = sprintf('%s#%s', $cacheKey ?: uniqid(), $attribute->getName());
            $constraint = $this->constraints[$key] ??= $attribute->newInstance();

            /** @var Constraint $constraint */
            $this->checkConstraint($constraint, $type, $name, $value);
        }
    }

    /**
     * Checks constraints of the passed validatable object reflection.
     *
     * @param Constraint $constraint The constraint to check.
     * @param string $type The type of the subject.
     * @param string $name The name of the subject.
     * @param mixed $value The value of the subject.
     *
     * @return void
     *
     * @throws ValidationFailedException If the constraint failed and its strategy is `Strategy::FailFast`.
     */
    protected function checkConstraint(Constraint $constraint, string $type, string $name, mixed $value): void
    {
        $validations = match (true) {
            $constraint instanceof ValidatesMany => ['' => $constraint->validate($value)][''],
            $constraint instanceof ValidatesOne  => ['' => $constraint->validate($value)],
            default                              => ['' => $constraint->validate($value)],
        };

        /** @var Result[] $validations */
        foreach ($validations as $field => $validation) {
            $key = trim(sprintf('%s.%s', $name, $field), '.');
            $id  = strtr('{type}[{key}]#{constraint}<{id}>', [
                '{type}'       => $type,
                '{key}'        => $key,
                '{constraint}' => $constraint::class,
                '{id}'         => spl_object_id($constraint),
            ]);

            $this->results[$id] = $result = $validation
                ->addAttribute('type', $type)
                ->addAttribute('key', $key);

            if ($validation->getResult() === false) {
                $this->errors[$id] = $result;

                if ($constraint->getStrategy() === Strategy::FailFast) {
                    $this->fail($result);
                }
            }
        }
    }

    private function fail(Result ...$violation): never
    {
        $violations = array_map(function ($violation) {
            /** @var Result $violation */
            return Utility::interpolate(
                'The {variable} ({value}) of the "{key}" {type} ' .
                'failed to pass the validation [{rules}]. {label} {problems}',
                [
                    'variable' => $violation->getAttribute('type') === self::METHOD_ATTRIBUTE ? 'return value' : 'value',
                    'type'     => $violation->getAttribute('type'),
                    'key'      => $violation->getAttribute('key'),
                    'value'    => $violation->getValue(),
                    'rules'    => $violation->getMetadata()['rules'],
                    'label'    => count($violation->getErrors()) === 1 ? 'Problem:' : 'Problems:',
                    'problems' => $violation->toString(),
                ]
            );
        }, $violation);

        $count      = 0;
        $violations = array_reduce($violations, function ($carry, $item) use (&$count) {
            return sprintf("%s\n(%02d) %s", $carry, ++$count, $item);
        });

        throw new ValidationFailedException(
            'Data failed to pass the validation. ' . $violations
        );
    }


    /**
     * Returns a unique identifier for the specifed reflection class name.
     *
     * @param string $reflection Reflection class name.
     * @param string $target The target of the reflection.
     * @param string $prefix The prefix of the target.
     * @param string $suffix The suffix of the target.
     *
     * @return string
     */
    private function getMemoizationKey(
        string $reflection,
        string $target = 'class',
        string $prefix = '::',
        string $suffix = '',
    ): string {
        return strtr('{reflection}@[{class}{prefix}{target}{suffix}]', [
            '{class}'      => $this->object::class,
            '{reflection}' => $reflection,
            '{prefix}'     => $prefix,
            '{target}'     => $target,
            '{suffix}'     => $suffix,
        ]);
    }
}

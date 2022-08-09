<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty;

use Stringable;
use Traversable;
use Countable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

/**
 * Result class.
 *
 * @package Mighty
 */
class Result implements
    Stringable,
    Traversable,
    Countable,
    ArrayAccess,
    IteratorAggregate
{
    protected array $attributes;

    /**
     * Result constructor.
     *
     * @param mixed $value
     * @param bool $result
     * @param array $validations
     * @param array $errors
     * @param array $metadata
     */
    public function __construct(
        public readonly mixed $value,
        public readonly bool $result,
        public readonly array $validations,
        public readonly array $errors,
        public readonly array $metadata,
    ) {
        $this->attributes = [
            // any additional attributes
            // 'key' => null,
        ];
    }

    /**
     * Returns error messages.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }


    /**
     * Result factory method.
     *
     * @param array<string,mixed> $data Result data. See `self::__construct()` for the expected data-types.
     *
     * @return self
     */
    public static function from(array $data): self
    {
        return new self(...$data);
    }


    /**
     * Returns the value of the result object.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Returns the final result of the result object.
     *
     * @return bool
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Returns the validations of the result object.
     *
     * @return array
     */
    public function getValidations(): array
    {
        return $this->validations;
    }


    /**
     * Returns the errors of the result object.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Returns the metadata of the result object.
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }


    /**
     * Returns the attributes (any additional variables) of the result object.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Returns a property or an attribute from the result object.
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getAttribute(string $name, mixed $default = null): mixed
    {
        return $this->{$name} ?? $this->attributes[$name] ?? $default;
    }

    /**
     * Adds an attribute to the result object.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addAttribute(string $name, mixed $value): static
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Removes an attribute from the result object.
     *
     * @param string $name
     *
     * @return static
     */
    public function removeAttribute(string $name): static
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }

        // properties are readonly,
        // only attributes are allowed to be unset

        return $this;
    }


    /**
     * Returns the result object as an array including the attributes.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            ...$this->getAttributes(),
            'value'       => $this->getValue(),
            'result'      => $this->getResult(),
            'validations' => $this->getValidations(),
            'errors'      => $this->getErrors(),
            'metadata'    => $this->getMetadata(),
        ];
    }

    /**
     * Returns the result object as a string
     *      (formatted error message or an empty string if there wasn't any errors).
     *
     * @return string
     */
    public function toString(): string
    {
        return array_reduce($this->errors, fn ($carry, $item) => (
            trim(sprintf('%s; %s.', trim($carry, '.,; '), trim($item, '.,')), ',; ')
        ), '');
    }


    /**
     * `Countable::count()` interface implementation.
     *
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->toArray());
    }


    /**
     * `ArrayAccess::offsetGet()` interface implementation.
     *
     * {@inheritDoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttribute($offset);
    }

    /**
     * `ArrayAccess::offsetSet()` interface implementation.
     *
     * {@inheritDoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->addAttribute($offset, $value);
    }

    /**
     * `ArrayAccess::offsetExists()` interface implementation.
     *
     * {@inheritDoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->getAttribute($offset) !== null;
    }

    /**
     * `ArrayAccess::offsetUnset()` interface implementation.
     *
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->removeAttribute($offset);
    }


    /**
     * `IteratorAggregate::getIterator()` interface implementation.
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->toArray());
    }
}

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Constraint;

use WeakMap;
use Throwable;
use MAKS\Mighty\Validation\Constraint\Validator;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectInterface;
use MAKS\Mighty\Exception\ValidationLogicException;

/**
 * The trait for implementing `ValidatableObjectInterface`.
 *
 * @implements ValidatableObjectInterface<object>
 *
 * @package Mighty\Validator
 */
trait ValidatableObjectTrait
{
    final public function getValidator(): Validator
    {
        if (!($this instanceof ValidatableObjectInterface)) {
            throw new ValidationLogicException(
                static::class . ' must implement ' . ValidatableObjectInterface::class
            );
        }

        static $validators = new WeakMap();

        if (!isset($validators[$this])) {
            $validators[$this] = new Validator($this);
        }

        return $validators[$this];
    }


    public function check(): void
    {
        $this->getValidator()->check();
    }

    public function validate(): array
    {
        return $this->getValidator()->validate();
    }

    public function isValid(): bool
    {
        try {
            $this->getValidator()->check();
        } catch (Throwable) {
            return false;
        }

        return true;
    }
}

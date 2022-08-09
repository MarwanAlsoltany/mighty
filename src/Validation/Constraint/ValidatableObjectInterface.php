<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Constraint;

use MAKS\Mighty\Validation\Constraint\Validator;
use MAKS\Mighty\Exception\ValidationFailedException;

/**
 * The interface for all validatable objects. See `ValidatableObjectTrait` for implementation.
 *
 * @package Mighty\Validator
 */
interface ValidatableObjectInterface
{
    /**
     * Returns an instance of the constraint Validator class associated with this object.
     *
     * @return Validator
     */
    public function getValidator(): Validator;

    /**
     * Checks the object and throws an exception if validation failed.
     *
     * @return void
     *
     * @throws ValidationFailedException If the validation failed.
     */
    public function check(): void;

    /**
     * Validates the object and returns the validation result.
     *
     * @return array<string|int,array<string,mixed>>
     */
    public function validate(): array;

    /**
     * Checks whether or not the object is valid.
     *
     * @return bool
     */
    public function isValid(): bool;
}

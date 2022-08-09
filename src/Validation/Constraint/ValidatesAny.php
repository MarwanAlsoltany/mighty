<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Constraint;

use MAKS\Mighty\Result;
use MAKS\Mighty\Exception\ValidationFailedException;

/**
 * Constraint interface.
 *
 * Child interfaces of the `ValidatesAny` interface should define
 * a more specific return type hint for the `self::validate()` method.
 *
 *
 * @package Mighty\Validator
 * @internal This interface should always be used by extension and is not intended to be implemented directly.
 */
interface ValidatesAny
{
    /**
     * Checks if the given value is valid and throws an exception if not.
     *
     * @param mixed $value The value to validate.
     *
     * @return void
     *
     * @throws ValidationFailedException
     */
    public function check(mixed $value = null): void;

    /**
     * Validates the given value and returns the validation result.
     *
     * @param mixed $value The value to validate.
     *
     * @return array<string,mixed>|array<string|int,Result> The validation result (single or multiple).
     */
    public function validate(mixed $value = null): array|Result;

    /**
     * Checks if the given value is valid.
     *
     * @param mixed $value The value to validate.
     *
     * @return bool Whether the value is valid or not.
     */
    public function isValid(mixed $value = null): bool;
}

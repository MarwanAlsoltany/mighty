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
use MAKS\Mighty\Validation\Constraint\ValidatesAny;

/**
 * Interface for constraints that validate multiple items.
 *
 * @package Mighty\Validator
 */
interface ValidatesMany extends ValidatesAny
{
    /**
     * {@inheritDoc}
     *
     * @return array<string|int,Result> The validation results.
     */
    public function validate(mixed $value = null): array;
}

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
 * Interface for constraints that validate a single item.
 *
 * @package Mighty\Validator
 */
interface ValidatesOne extends ValidatesAny
{
    /**
     * {@inheritDoc}
     *
     * @return Result The validation result.
     */
    public function validate(mixed $value = null): Result;
}

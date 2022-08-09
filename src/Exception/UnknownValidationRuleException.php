<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Exception;

use RangeException as Exception;
use MAKS\Mighty\Exception\ValidatorThrowable;

/**
 * Exception thrown when attempt is made to execute an unknown validation rule.
 *
 * @package Mighty\Validator
 */
class UnknownValidationRuleException extends Exception implements ValidatorThrowable
{
    // ...
}

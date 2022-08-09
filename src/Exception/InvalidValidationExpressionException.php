<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Exception;

use RuntimeException as Exception;
use MAKS\Mighty\Exception\ValidatorThrowable;

/**
 * Exception thrown when a validation expression is invalid.
 *
 * @package Mighty
 */
class InvalidValidationExpressionException extends Exception implements ValidatorThrowable
{
    // ...
}

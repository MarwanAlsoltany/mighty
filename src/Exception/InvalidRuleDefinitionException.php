<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Exception;

use InvalidArgumentException as Exception;
use MAKS\Mighty\Throwable;

/**
 * Exception thrown when rule definition is invalid.
 *
 * @package Mighty
 */
class InvalidRuleDefinitionException extends Exception implements Throwable
{
    // ...
}

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation;

use MAKS\Mighty\Validation\SmartEnum;

/**
 * Validation expression behavior.
 *
 * @package Mighty\Validator
 */
enum Behavior: string
{
    use SmartEnum;


    case Normal      = '';

    case Optimistic  = '?';

    case Pessimistic = '!';
}

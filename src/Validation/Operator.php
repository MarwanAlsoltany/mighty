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
 * Validation expression operator.
 *
 * @package Mighty\Validator
 */
enum Operator: string
{
    use SmartEnum;


    case Not   = '~';

    case And   = '&';

    case Or    = '|';

    case Xor   = '^';

    case Open  = '(';

    case Close = ')';
}

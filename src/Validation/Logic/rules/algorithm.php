<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Logic;

use MAKS\Mighty\Rule;

return [

    'luhn' => (new Rule())
        ->name('luhn')
        ->callback(function (mixed $input): bool {
            if (!is_scalar($input)) {
                return false;
            }


            $number  = preg_replace('/[^\d]/', '', strval($input));
            $reverse = strrev($number);
            $length  = strlen($number);
            $sum     = 0;

            for ($i = 0; $i < $length; $i++) {
                $digit = (int)$reverse[$i];
                $sum += $i & 1
                    ? ($digit > 4 ? $digit * 2 - 9 : $digit * 2)
                    : ($digit * 1);
            }

            return $length > 2 && $sum % 10 === 0;
        })
        ->parameters(['@input'])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must pass the Luhn Algorithm check.')
        ->example('luhn')
        ->description('Asserts that the input passes the Luhn Algorithm check. This rule is mostly used in conjunction with other rules like credit card numbers and identifiers to further check the validity of the subject.'),

];

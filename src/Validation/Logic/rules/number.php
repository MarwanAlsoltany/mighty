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

    'number.isPositive' => (new Rule())
        ->name('number.isPositive')
        ->callback(fn (mixed $input): bool => is_numeric($input) && floatval($input) > 0)
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a positive number.')
        ->example('number.isPositive')
        ->description('Asserts that the input is a positive number.'),

    'number.isNegative' => (new Rule())
        ->name('number.isNegative')
        ->callback(fn (mixed $input): bool => is_numeric($input) && floatval($input) < 0)
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a negative number.')
        ->example('number.isNegative')
        ->description('Asserts that the input is a negative number.'),

    'number.isEven' => (new Rule())
        ->name('number.isEven')
        ->callback(fn (mixed $input): bool => is_numeric($input) && floatval($input) % 2 === 0)
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an even number.')
        ->example('number.isEven')
        ->description('Asserts that the input is an even number.'),

    'number.isOdd' => (new Rule())
        ->name('number.isOdd')
        ->callback(fn (mixed $input): bool => is_numeric($input) && floatval($input) % 2 !== 0)
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an odd number.')
        ->example('number.isOdd')
        ->description('Asserts that the input is an odd number.'),

    'number.isMultipleOf' => (new Rule())
        ->name('number.isMultipleOf')
        ->arguments(['float'])
        ->callback(fn (mixed $input, float $multiple): bool => is_numeric($input) && $multiple && floatval($input) % $multiple === 0)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a multiple of ${@arguments.0}.')
        ->example('number.isMultipleOf:3')
        ->description('Asserts that the input is a multiple of the given number.'),

    'number.isFinite' => (new Rule())
        ->name('number.isFinite')
        ->callback(fn (mixed $input): bool => is_numeric($input) && is_finite(floatval($input)))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a finite number.')
        ->example('number.isFinite')
        ->description('Asserts that the input is a finite number.'),

    'number.isInfinite' => (new Rule())
        ->name('number.isInfinite')
        ->callback(fn (mixed $input): bool => is_numeric($input) && is_infinite(floatval($input)))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a infinite number.')
        ->example('number.isInfinite')
        ->description('Asserts that the input is an infinite number.'),

    'number.isNan' => (new Rule())
        ->name('number.isNan')
        ->callback(fn (mixed $input): bool => is_numeric($input) && is_nan(floatval($input)))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a NAN number.')
        ->example('number.isNan')
        ->description('Asserts that the input is a not a number.'),

];

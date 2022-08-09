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
use MAKS\Mighty\Support\Inspector;

return [

    'count' => (new Rule())
        ->name('count')
        ->arguments(['float'])
        ->callback(fn (mixed $input, float $count): bool => Inspector::getCount($input) == $count)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be ${@arguments.0} or have a value/count/length that is equal to ${@arguments.0}.')
        ->example('count:3')
        ->description('Asserts that the input count is equal to the given value. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).'),

    'min' => (new Rule())
        ->name('min')
        ->arguments(['float'])
        ->callback([Inspector::class, 'getCount'])
        ->parameters(['@input'])
        ->comparison(['@output', '>=', '@arguments.0'])
        ->message('${@label} must be at least ${@arguments.0} or have a value/count/length that is at least ${@arguments.0}.')
        ->example('min:3')
        ->description('Asserts that the input count is greater than or equal to the given value. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).'),

    'max' => (new Rule())
        ->name('max')
        ->arguments(['float'])
        ->callback([Inspector::class, 'getCount'])
        ->parameters(['@input'])
        ->comparison(['@output', '<=', '@arguments.0'])
        ->message('${@label} must be at most ${@arguments.0} or have a value/count/length that is at most ${@arguments.0}.')
        ->example('max:3')
        ->description('Asserts that the input count is less than or equal to the given value. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).'),

    'between' => (new Rule())
        ->name('between')
        ->arguments(['float', 'float'])
        ->callback(fn (mixed $input, float $min, float $max): bool => Inspector::getCount($input) >= $min && Inspector::getCount($input) <= $max)
        ->parameters(['@input', '@arguments.0', '@arguments.1'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must have a count that is between ${@arguments.0} and ${@arguments.1}.')
        ->message('${@label} must be between ${@arguments.0} and ${@arguments.1} or have a value/count/length that is between ${@arguments.0} and ${@arguments.1}.')
        ->example('between:3,7')
        ->description('Asserts that the input count is between the given values. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).'),

];

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

    'array.hasKey' => (new Rule())
        ->name('array.hasKey')
        ->arguments(['mixed'])
        ->callback(fn (mixed $input, string|int $key): bool => is_array($input) && array_key_exists($key, $input))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must have the key: ${@arguments.0}.')
        ->example('array.hasKey:key')
        ->description('Asserts that the input array has the given key.'),

    'array.hasValue' => (new Rule())
        ->name('array.hasValue')
        ->arguments(['mixed'])
        ->callback(fn (mixed $input, mixed $value): bool => is_array($input) && in_array($value, $input))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must contain the value: ${@arguments.0}.')
        ->example('array.hasValue:value')
        ->description('Asserts that the input array contains the given value. Works with scalar types.'),

    'array.hasDistinct' => (new Rule())
        ->name('array.hasDistinct')
        ->arguments(['mixed'])
        ->callback(fn (mixed $input, string|int $key): bool => is_array($input) && array_values($input) == array_values(array_column($input, null, $key)))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a multidimensional array that contains distinct values for the key: ${@arguments.0}.')
        ->example('array.hasDistinct:key')
        ->description('Asserts that the input is a multidimensional array that contains distinct values of the given key.'),

    'array.isAssociative' => (new Rule())
        ->name('array.isAssociative')
        ->callback(fn (mixed $input): bool => is_array($input) && array_keys($input) != range(0, count($input) - 1))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an associative array.')
        ->example('array.isAssociative')
        ->description('Asserts that the input is an associative array.'),

    'array.isSequential' => (new Rule())
        ->name('array.isSequential')
        ->callback(fn (mixed $input): bool => is_array($input) && array_keys($input) == range(0, count($input) - 1))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a sequential array.')
        ->example('array.isSequential')
        ->description('Asserts that the input is a sequential array.'),

    'array.isUnique' => (new Rule())
        ->name('array.isUnique')
        ->callback(fn (mixed $input): bool => is_array($input) && ($count = count($input)) == count($input, COUNT_RECURSIVE) && $count === count(array_unique($input)))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must contain unique values.')
        ->example('array.isUnique')
        ->description('Asserts that the input array contains unique values. Works only with one-dimensional arrays.'),

    'array.subset' => (new Rule())
        ->name('array.subset')
        ->arguments(['array'])
        ->callback(function (mixed $input, array $subset): bool {
            if (!is_array($input) || !is_array($subset)) {
                return false;
            }

            // array_diff_assoc() checks only one dimensional arrays
            $filter = fn (mixed $value) => is_scalar($value) || is_null($value);
            $whole  = array_filter($input, $filter);
            $subset = array_filter($subset, $filter);
            ksort($whole);
            ksort($subset);

            return array_diff_assoc($subset, $whole) === [];
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an array that contains ${@arguments.0}.')
        ->example('array.subset:\'{"a":1,"b":2}\'')
        ->description('Asserts that the input is an array that contains the given subset. Note that this check applies only to the first dimension of the array.'),

];

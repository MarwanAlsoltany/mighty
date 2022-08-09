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

    'empty' => (new Rule())
        ->name('empty')
        ->callback(fn (mixed $input): bool => empty($input))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be empty.')
        ->example('empty')
        ->description('Asserts that the input is empty using empty() language construct (is blank, i.e. empty string, empty array, false, null, or 0).'),

    'required' => (new Rule())
        ->name('required')
        ->callback(fn (mixed $input): bool => !Inspector::isEmpty($input))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} is required.')
        ->example('required')
        ->description('Asserts that the input is required (is not blank, i.e. not a empty string or null).'),

    'allowed' => (new Rule())
        ->name('allowed')
        ->callback(fn (mixed $input): bool => Inspector::isEmpty($input) === false || $input === null || $input === '')
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} is allowed.')
        ->example('allowed')
        ->description('Asserts that the input is allowed (can be empty or have any value, null and empty string are considered valid values).'),

    'forbidden' => (new Rule())
        ->name('forbidden')
        ->comparison(['@output', '===', null])
        ->message('${@label} is forbidden (must not be present).')
        ->example('forbidden')
        ->description('Asserts that the input is forbidden (is null or not present).'),

    'accepted' => (new Rule())
        ->name('accepted')
        ->callback(function (mixed $input): bool {
            $input  = is_string($input) ? strtoupper($input) : $input;
            $values = ['ON', 'YES', 'YEAH', 'YEP', 'YO', 'OK', 'OKAY', 'AYE', '1', 'TRUE', 1, true];

            return in_array($input, $values, true);
        })
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be accepted.')
        ->example('accepted')
        ->description('Asserts that the input is accepted (equals: "on", "yes", "yeah", "yep", "yo", "ok", "okay", "aye", 1 or "1", true or "true") note that strings are treated in a case-insensitive manner.'),

    'declined' => (new Rule())
        ->name('declined')
        ->callback(function (mixed $input): bool {
            $input  = is_string($input) ? strtoupper($input) : $input;
            $values = ['OFF', 'NO', 'NOT', 'NOPE', 'NEH', 'NAY', '0', 'FALSE', 0, false];

            return in_array($input, $values, true);
        })
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be declined.')
        ->example('declined')
        ->description('Asserts that the input is declined (equals: "off", "no", "not", "nope", "neh", "nay", 0 or "0", false or "false") note that strings are treated in a case-insensitive manner.'),

    'bit' => (new Rule())
        ->name('bit')
        ->callback(fn (mixed $input): bool => in_array($input, [0, 1, '0', '1', true, false], true))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a bit.')
        ->example('bit')
        ->description('Asserts that the input is bit (equals: 1 or "1", true; 0 or "0", false).'),

    'bit.isOn' => (new Rule())
        ->name('bit.isOn')
        ->callback(fn (mixed $input): bool => in_array($input, [1, '1', true], true))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a turned on bit.')
        ->example('bit.isOn')
        ->description('Asserts that the input is a turned on bit (equals: true, 1 or "1").'),

    'bit.isOff' => (new Rule())
        ->name('bit.isOff')
        ->callback(fn (mixed $input): bool => in_array($input, [0, '0', false], true))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a turned off bit.')
        ->example('bit.isOff')
        ->description('Asserts that the input is a turned off bit (equals: false, 0 or "0").'),

    'equals' => (new Rule())
        ->name('equals')
        ->arguments(['mixed'])
        ->comparison(['@output', '==', '@arguments.0'])
        ->message('${@label} must be equal to ${@arguments.0}.')
        ->example('equals:value')
        ->description('Asserts that the input is equal to the given value. Works with scalar types and null. Comparison operator is "==".'),

    'matches' => (new Rule())
        ->name('matches')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && strlen($pattern) && preg_match($pattern, $input))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must match the regex pattern ${@arguments.0}.')
        ->example('matches:\'"/^[a-zA-Z0-9]+$/"\'')
        ->description('Asserts that the input matches the given pattern. Works with strings only.'),

    'in' => (new Rule())
        ->name('in')
        ->arguments(['...mixed'])
        ->callback(fn (mixed $input, array $values): bool => in_array($input, $values))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be one of the following values: ${@arguments.0}.')
        ->example('in:val1,val2,...')
        ->description('Asserts that the input is in the given values. Works with scalar types and null.'),

];

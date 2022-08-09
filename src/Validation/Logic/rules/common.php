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
use MAKS\Mighty\Validation\Pattern\Regex;

return [

    'uuid' => (new Rule())
        ->name('uuid')
        ->arguments(['mixed'])
        ->callback(function (mixed $input, string|int|null $version): bool {
            $key     = trim('uuid.v' . trim(strtolower(strval($version))), '.v');
            $pattern = Regex::PATTERNS[$key] ?? Regex::UUID;

            return is_string($input) && preg_match($pattern, $input);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid UUID-{@arguments.0:[v1/v2/v3/v4/v5]}.')
        ->example('uuid')
        ->description('Asserts that the input is a valid UUID. The version (v1/v2/v3/v4/v5) can be specifed to narrow the pattern.'),

    'ascii' => (new Rule())
        ->name('ascii')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::ASCII])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be an ASCII compliant string.')
        ->example('ascii')
        ->description('Asserts that the input is a string containing only ASCII characters (ASCII compliant string).'),

    'slug' => (new Rule())
        ->name('slug')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::SLUG])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid slug.')
        ->example('slug')
        ->description('Asserts that the input is a valid slug.'),

    'meta' => (new Rule())
        ->name('meta')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::META])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must contain only special characters (i.e. "@, #, $, ...").')
        ->example('meta')
        ->description('Asserts that the input is a string containing only meta characters (special characters) (i.e. "@, #, $, ...")..'),

    'text' => (new Rule())
        ->name('text')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::TEXT])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must contain only letters and punctuation from any language.')
        ->example('text')
        ->description('Asserts that the input is a string containing letters and punctuation from any language.'),

    'words' => (new Rule())
        ->name('words')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::WORDS])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must contain only words and spaces.')
        ->example('words')
        ->description('Asserts that the input is a string containing only words and spaces without any other character.'),

    'spaceless' => (new Rule())
        ->name('spaceless')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::SPACELESS])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must contain no whitespace characters.')
        ->example('spaceless')
        ->description('Asserts that the input is a string containing no whitespace characters.'),

    'emoji' => (new Rule())
        ->name('emoji')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::EMOJI])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must contain an emoji.')
        ->example('emoji')
        ->description('Asserts that the input contains an emoji.'),

    'roman' => (new Rule())
        ->name('roman')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::ROMAN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid roman number.')
        ->example('roman')
        ->description('Asserts that the input is a valid roman number.'),

    'phone' => (new Rule())
        ->name('phone')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::PHONE])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid phone number.')
        ->example('phone')
        ->description('Asserts that the input is a valid phone number (supports: North America, Europe and most Asian and Middle East countries).'),

    'geolocation' => (new Rule())
        ->name('geolocation')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::GEOLOCATION])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid geolocation (latitude and longitude coordinates combination).')
        ->example('geolocation')
        ->description('Asserts that the input is a valid geolocation (latitude and longitude coordinates combination).'),


    'version' => (new Rule())
        ->name('version')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::VERSION])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid semantic version number.')
        ->example('version')
        ->description('Asserts that the input is a valid semantic version number.'),


    'amount' => (new Rule())
        ->name('amount')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::AMOUNT])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must contain only numbers, an optional decimal point (comma or dot), and an optional minus.')
        ->example('amount')
        ->description('Asserts that the input contains only numbers, an optional decimal point (comma or dot), and an optional minus (used for amounts of money for example).'),

    'amount.dollar' => (new Rule())
        ->name('amount.dollar')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::AMOUNT_DOLLAR])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must a be validly formatted amount of USD like "$1,000.00" or "US$ 4.99", decimal point and thousands separator are optional.')
        ->example('amount.dollar')
        ->description('Asserts that the input is a validly formatted amount of USD, where decimal point and thousands separator are optional.'),

    'amount.euro' => (new Rule())
        ->name('amount.euro')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::AMOUNT_EURO])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must a be validly formatted amount of EUR like "1,000.00 €" or "4.99 EUR", decimal point and thousands separator are optional.')
        ->example('amount.euro')
        ->description('Asserts that the input is a validly formatted amount of EUR, where decimal point and thousands separator are optional.'),

];

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

    'locale' => (new Rule())
        ->name('locale')
        ->arguments(['bool'])
        ->callback(function (mixed $input, bool $strict = false): bool {
            if (!is_string($input)) {
                return false;
            }

            $locales = \ResourceBundle::getLocales('');

            $input   = $strict ? $input : strtr(strtolower(explode('.', $input)[0]), ['-' => '_']);
            $locales = $strict ? $locales : array_map('strtolower', $locales);

            return in_array($input, $locales);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a valid locale identifier.')
        ->example('locale')
        ->description('Asserts that the input is a valid locale identifier (default: [ISO 639-1] or [ISO 639-1]_[ISO 3166-1 alpha-2], case-insensitive, input is canonicalized before checking (dashes to underscores, no dots or charset); strict: [ISO 639-1] or [ISO 639-1]_[ISO 3166-1 alpha-2], case-sensitive without canonicalization.'),

    'language' => (new Rule())
        ->name('language')
        ->arguments(['bool'])
        ->callback(fn (mixed $input, ?bool $long = false): bool => is_string($input) && ($pattern = $long ? Regex::LANGUAGE_ALPHA3 : Regex::LANGUAGE_ALPHA2) && preg_match($pattern, $input))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a valid language code.')
        ->example('language')
        ->description('Asserts that the input is a valid language code (default: "ISO 639-1"; long: "ISO 639-2/T").'),

    'country' => (new Rule())
        ->name('country')
        ->arguments(['bool'])
        ->callback(fn (mixed $input, ?bool $long = false): bool => is_string($input) && ($pattern = $long ? Regex::COUNTRY_ALPHA3 : Regex::COUNTRY_ALPHA2) && preg_match($pattern, $input))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a valid country code.')
        ->example('country')
        ->description('Asserts that the input is a valid country code (default: "ISO 3166-1 alpha-2"; long: "ISO 3166-1 alpha-3").'),

];

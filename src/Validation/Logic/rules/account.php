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

    'username' => (new Rule())
        ->name('username')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::USERNAME])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid username (between 4-32 characters, consists of letters in any case, optionally numbers, optionally one of the following characters "-_." (not consecutive), and must always start with a letter and end with a letter or number).')
        ->example('username')
        ->description('Asserts that the input is a valid username (between 4-32 characters, consists of letters in any case, optionally numbers, optionally one of the following characters "-_." (not consecutive), and must always start with a letter and end with a letter or number).'),

    'password' => (new Rule())
        ->name('password')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::PASSWORD])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid password (minimum 8 characters, consists of at least one small letter and one capital letter, at least one number, at least one special character, and optionally a space).')
        ->example('password')
        ->description('Asserts that the input is a valid password (minimum 8 characters, consists of at least one small letter and one capital letter, at least one number, at least one special character, and optionally a space).'),

];

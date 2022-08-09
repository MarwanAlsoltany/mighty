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

    'php.keyword' => (new Rule())
        ->name('php.keyword')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::PHP_KEYWORD])
        ->comparison(['@output', '!=', false])
        ->message('${@label} is not a PHP language Keyword.')
        ->example('php.keyword')
        ->description('Asserts that the input is a PHP language keyword.'),

    'php.reserved' => (new Rule())
        ->name('php.reserved')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::PHP_RESERVED])
        ->comparison(['@output', '!=', false])
        ->message('${@label} is not a PHP language reserved word.')
        ->example('php.reserved')
        ->description('Asserts that the input is a PHP language reserved word.'),

    'php.reserved.extra' => (new Rule())
        ->name('php.reserved.extra')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::PHP_RESERVED_EXTRA])
        ->comparison(['@output', '!=', false])
        ->message('${@label} is not a PHP language reserved word including soft reserved words.')
        ->example('php.reserved.extra')
        ->description('Asserts that the input is a PHP language reserved word including soft reserved words.'),

];

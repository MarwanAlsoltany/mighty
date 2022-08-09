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

    'alpha' => (new Rule())
        ->name('alpha')
        ->callback(fn ($input) => is_string($input) && ctype_alpha($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of alphabetic characters only.')
        ->example('alpha')
        ->description('Asserts that the input consists of alphabetic characters only.'),

    'alnum' => (new Rule())
        ->name('alnum')
        ->callback(fn ($input) => is_string($input) && ctype_alnum($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of alphanumeric characters only.')
        ->example('alnum')
        ->description('Asserts that the input consists of alphanumeric characters only.'),

    'lower' => (new Rule())
        ->name('lower')
        ->callback(fn ($input) => is_string($input) && ctype_lower($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of lowercase characters only.')
        ->example('lower')
        ->description('Asserts that the input consists of lowercase characters only.'),

    'upper' => (new Rule())
        ->name('upper')
        ->callback(fn ($input) => is_string($input) && ctype_upper($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of uppercase characters only.')
        ->example('upper')
        ->description('Asserts that the input consists of uppercase characters only.'),

    'cntrl' => (new Rule())
        ->name('cntrl')
        ->callback(fn ($input) => is_string($input) && ctype_cntrl($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of control characters only.')
        ->example('cntrl')
        ->description('Asserts that the input consists of control characters only.'),

    'space' => (new Rule())
        ->name('space')
        ->callback(fn ($input) => is_string($input) && ctype_space($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of whitespace characters only.')
        ->example('space')
        ->description('Asserts that the input consists of whitespace characters only.'),

    'punct' => (new Rule())
        ->name('punct')
        ->callback(fn ($input) => is_string($input) && ctype_punct($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of punctuation characters only.')
        ->example('punct')
        ->description('Asserts that the input consists of punctuation characters only.'),

    'graph' => (new Rule())
        ->name('graph')
        ->callback(fn ($input) => is_string($input) && ctype_graph($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of graphic characters only.')
        ->example('graph')
        ->description('Asserts that the input consists of graphic characters only (characters that create a visible output).'),

    'print' => (new Rule())
        ->name('print')
        ->callback(fn ($input) => is_string($input) && ctype_print($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of printable characters only.')
        ->example('print')
        ->description('Asserts that the input consists of printable characters only.'),

    'digit' => (new Rule())
        ->name('digit')
        ->callback(fn ($input) => is_string($input) && ctype_digit($input))
        ->parameters(['@input'])
        ->message('${@label} must consist of digits only.')
        ->example('digit')
        ->description('Asserts that the input consists of a digits only (numeric characters).'),

    'xdigit' => (new Rule())
        ->name('xdigit')
        ->callback(fn ($input) => is_string($input) && ctype_xdigit($input))
        ->parameters(['@input'])
        ->message('${@label} must be a hexadecimal digit.')
        ->example('xdigit')
        ->description('Asserts that the input represent hexadecimal digits.'),

];

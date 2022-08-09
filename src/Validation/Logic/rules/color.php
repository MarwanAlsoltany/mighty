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

    'color' => (new Rule())
        ->name('color')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid CSS color.')
        ->example('color')
        ->description('Asserts that the input is a valid CSS color (Keyword "loose", HEX, HEX-Alpha, RGB, RGBA, RGB "new syntax", HSL, HSLA, HSL "new syntax").'),

    'color.hex' => (new Rule())
        ->name('color.hex')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HEX])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid HEX color.')
        ->example('color.hex')
        ->description('Asserts that the input is a valid CSS HEX color.'),

    'color.hexShort' => (new Rule())
        ->name('color.hexShort')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HEX_SHORT])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid 3-Char-HEX color.')
        ->example('color.hexShort')
        ->description('Asserts that the input is a valid CSS 3-Char-HEX color.'),

    'color.hexLong' => (new Rule())
        ->name('color.hexLong')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HEX_LONG])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid 6-Char-HEX color.')
        ->example('color.hexLong')
        ->description('Asserts that the input is a valid CSS 6-Char-HEX color.'),

    'color.hexAlpha' => (new Rule())
        ->name('color.hexAlpha')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HEX_ALPHA])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid HEX-Alpha (4 or 8 Chars) color.')
        ->example('color.hexAlpha')
        ->description('Asserts that the input is a valid CSS HEX-Alpha (4 or 8 Chars) color.'),

    'color.rgb' => (new Rule())
        ->name('color.rgb')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_RGB])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid RGB color.')
        ->example('color.rgb')
        ->description('Asserts that the input is a valid CSS RGB color.'),

    'color.rgba' => (new Rule())
        ->name('color.rgba')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_RGBA])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid RGBA color.')
        ->example('color.rgba')
        ->description('Asserts that the input is a valid CSS RGBA color.'),

    'color.rgb.new' => (new Rule())
        ->name('color.rgb.new')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_RGB_NEW])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid CSS4 RGB color.')
        ->example('color.rgb.new')
        ->description('Asserts that the input is a valid CSS4 RGB color.'),

    'color.hsl' => (new Rule())
        ->name('color.hsl')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HSL])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid HSL color.')
        ->example('color.hsl')
        ->description('Asserts that the input is a valid CSS HSL color.'),

    'color.hsla' => (new Rule())
        ->name('color.hsla')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HSLA])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid HSLA color.')
        ->example('color.hsla')
        ->description('Asserts that the input is a valid CSS HSLA color.'),

    'color.hsl.new' => (new Rule())
        ->name('color.hsl.new')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_HSL_NEW])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid CSS4 HSL color.')
        ->example('color.hsl.new')
        ->description('Asserts that the input is a valid CSS4 HSL color.'),

    'color.keyword' => (new Rule())
        ->name('color.keyword')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::COLOR_KEYWORD])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid CSS keyword color.')
        ->example('color.keyword')
        ->description('Asserts that the input is a valid CSS keyword color (strict, as in the CSS specification).'),

];

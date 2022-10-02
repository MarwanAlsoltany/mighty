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

    'image' => (new Rule())
        ->name('image')
        ->callback(fn (mixed $input): bool => is_string($input) && file_exists($input) && strpos(mime_content_type($input), 'image/') !== false)
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image.')
        ->example('image')
        ->description('Asserts that the input is an image file (jpg, jpeg, png, gif, bmp, svg, or webp).'),

    'image.width' => (new Rule())
        ->name('image.width')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $width): bool => is_string($input) && file_exists($input) && ($info = getimagesize($input)) && $info[0] == $width)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its width must be equal to ${@arguments.0} pixels.')
        ->example('image.width:1920')
        ->description('Asserts that the input is an image and its width is equal to the given width in pixels.'),

    'image.width.lte' => (new Rule())
        ->name('image.width.lte')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $width): bool => is_string($input) && file_exists($input) && ($info = getimagesize($input)) && $info[0] <= $width)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its width must be less than or equal to ${@arguments.0} pixels.')
        ->example('image.width.lte:1920')
        ->description('Asserts that the input is an image and its width is less than or equal to the given width in pixels.'),

    'image.width.gte' => (new Rule())
        ->name('image.width.gte')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $width): bool => is_string($input) && file_exists($input) && ($info = getimagesize($input)) && $info[0] >= $width)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its width must be greater than or equal to ${@arguments.0} pixels.')
        ->example('image.width.gte:1920')
        ->description('Asserts that the input is an image and its width is greater than or equal to the given width in pixels.'),

    'image.height' => (new Rule())
        ->name('image.height')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $height): bool => is_string($input) && file_exists($input) && ($info = getimagesize($input)) && $info[1] == $height)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its height must be equal to ${@arguments.0} pixels.')
        ->example('image.height:1080')
        ->description('Asserts that the input is an image and its height is equal to the given height in pixels.'),

    'image.height.lte' => (new Rule())
        ->name('image.height.lte')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $height): bool => is_string($input) && file_exists($input) && ($info = getimagesize($input)) && $info[1] <= $height)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its height must be less than or equal to ${@arguments.0} pixels.')
        ->example('image.height.lte:1080')
        ->description('Asserts that the input is an image and its height is less than or equal to the given height in pixels.'),

    'image.height.gte' => (new Rule())
        ->name('image.height.gte')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $height): bool => is_string($input) && file_exists($input) && ($info = getimagesize($input)) && $info[1] >= $height)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its height must be greater than or equal to ${@arguments.0} pixels.')
        ->example('image.height.gte:1080')
        ->description('Asserts that the input is an image and its height is greater than or equal to the given height in pixels.'),

    'image.dimensions' => (new Rule())
        ->name('image.dimensions')
        ->arguments(['int', 'int', 'string'])
        ->callback(function (mixed $input, int $width, int $height, string $operator): bool {
            if (!is_string($input) || !file_exists($input) || !($info = getimagesize($input))) {
                return false;
            }

            $compare = Inspector::OPERATIONS[$operator] ?? Inspector::OPERATIONS['=='];

            return $compare($info[0], $width) && $compare($info[1], $height);
        })
        ->parameters(['@input', '@arguments.0', '@arguments.1', '@arguments.2:=='])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its dimensions must be ${@arguments.2:==} ${@arguments.0}x${@arguments.1}px.')
        ->example('image.dimensions:1920,1080,==')
        ->description('Asserts that the input is an image and its dimensions are less than, equal to, or greater than the given width and height in pixels.'),

    'image.ratio' => (new Rule())
        ->name('image.ratio')
        ->arguments(['string'])
        ->callback(function (mixed $input, string $ratio): bool {
            if (!is_string($input) || !file_exists($input) || !($info = getimagesize($input))) {
                return false;
            }

            $ratio = strpos($ratio, ':') !== false ? $ratio : $ratio . ':1';

            [$x, $y] = explode(':', $ratio);
            [$x, $y] = [intval($x), intval($y)];

            return $x > 0 && $y > 0 && ($x / $y) === ($info[0] / $info[1]);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an image and its ratio must be equal to ${@arguments.0}.')
        ->example('image.ratio:16:9')
        ->description('Asserts that the input is an image and its aspect ratio is equal to the given ratio (ratio must be specified as fraction like "16/9").'),

];

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

    'file' => (new Rule())
        ->name('file')
        ->callback(fn (mixed $input): bool => is_string($input) && file_exists($input))
        ->parameters(['@input'])
        ->message('${@label} must be a file (can be a file, a link, or a directory).')
        ->example('file')
        ->description('Asserts that the input is a file (can be a file, a link, or a directory).'),

    'file.isFile' => (new Rule())
        ->name('file.isFile')
        ->callback(fn (mixed $input): bool => is_string($input) && is_file($input))
        ->parameters(['@input'])
        ->message('${@label} must be a file.')
        ->example('file.isFile')
        ->description('Asserts that the input is a file.'),

    'file.isLink' => (new Rule())
        ->name('file.isLink')
        ->callback(fn (mixed $input): bool => is_string($input) && is_link($input))
        ->parameters(['@input'])
        ->message('${@label} must be a link.')
        ->example('file.isLink')
        ->description('Asserts that the input is a link.'),

    'file.isDirectory' => (new Rule())
        ->name('file.isDirectory')
        ->callback(fn (mixed $input): bool => is_string($input) && is_dir($input))
        ->parameters(['@input'])
        ->message('${@label} must be a directory.')
        ->example('file.isDirectory')
        ->description('Asserts that the input is a directory.'),

    'file.isExecutable' => (new Rule())
        ->name('file.isExecutable')
        ->callback(fn (mixed $input): bool => is_string($input) && is_executable($input))
        ->parameters(['@input'])
        ->message('${@label} must be a file and is executable.')
        ->example('file.isExecutable')
        ->description('Asserts that the input is a file and is executable.'),

    'file.isWritable' => (new Rule())
        ->name('file.isWritable')
        ->callback(fn (mixed $input): bool => is_string($input) && is_writable($input))
        ->parameters(['@input'])
        ->message('${@label} must be a file and is writable.')
        ->example('file.isWritable')
        ->description('Asserts that the input is a file and is writable.'),

    'file.isReadable' => (new Rule())
        ->name('file.isReadable')
        ->callback(fn (mixed $input): bool => is_string($input) && is_readable($input))
        ->parameters(['@input'])
        ->message('${@label} must be a file and is readable.')
        ->example('file.isReadable')
        ->description('Asserts that the input is a file and is readable.'),

    'file.isUploaded' => (new Rule())
        ->name('file.isUploaded')
        ->callback(fn (mixed $input): bool => is_string($input) && is_uploaded_file($input))
        ->parameters(['@input'])
        ->message('${@label} must be a file that is uploaded via HTTP POST.')
        ->example('file.isUploaded')
        ->description('Asserts that the input is a file that is uploaded via HTTP POST.'),

    'file.size' => (new Rule())
        ->name('file.size')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $size): bool => is_string($input) && file_exists($input) && ($actual = filesize($input)) && $actual === $size)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and the size must be equal to ${@arguments.0} bytes.')
        ->example('file.size:1024')
        ->description('Asserts that the input is a file and the size is equal to the given size in bytes.'),

    'file.size.lte' => (new Rule())
        ->name('file.size.lte')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $size): bool => is_string($input) && file_exists($input) && ($actual = filesize($input)) && $actual <= $size)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and the size must be less than or equal to ${@arguments.0} bytes.')
        ->example('file.size.lte:1024')
        ->description('Asserts that the input is a file and the size is less than or equal to the given size in bytes.'),

    'file.size.gte' => (new Rule())
        ->name('file.size.gte')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $size): bool => is_string($input) && file_exists($input) && ($actual = filesize($input)) && $actual >= $size)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and the size must be greater than or equal to ${@arguments.0} bytes.')
        ->example('file.size.gte:1024')
        ->description('Asserts that the input is a file and the size is greater than or equal to the given size in bytes.'),

    'file.dirname' => (new Rule())
        ->name('file.dirname')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $dirname): bool => is_string($input) && pathinfo($input, PATHINFO_DIRNAME) === trim($dirname))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and its dirname must be equal to ${@arguments.0}.')
        ->example('file.dirname:/path/to/dir')
        ->description('Asserts that the input is a file and its dirname is equal to the given dirname.'),

    'file.basename' => (new Rule())
        ->name('file.basename')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $basename): bool => is_string($input) && pathinfo($input, PATHINFO_BASENAME) === trim($basename))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and its basename must be equal to ${@arguments.0}.')
        ->example('file.basename:file.ext')
        ->description('Asserts that the input is a file and its basename is equal to the given basename.'),

    'file.filename' => (new Rule())
        ->name('file.filename')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $filename): bool => is_string($input) && pathinfo($input, PATHINFO_FILENAME) === trim($filename))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and its filename must be equal to ${@arguments.0}.')
        ->example('file.filename:file')
        ->description('Asserts that the input is a file and its filename is equal to the given filename.'),

    'file.extension' => (new Rule())
        ->name('file.extension')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $extension): bool => is_string($input) && pathinfo($input, PATHINFO_EXTENSION) === trim($extension, '.'))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and its extension must be equal to ${@arguments.0}.')
        ->example('file.extension:ext')
        ->description('Asserts that the input is a file and its extension is equal to the given extension.'),

    'file.mime' => (new Rule())
        ->name('file.mime')
        ->arguments(['array'])
        ->callback(fn (mixed $input, array $mimes): bool => is_string($input) && file_exists($input) && in_array(mime_content_type($input), $mimes))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a file and its MIME type must be ${@arguments.0}.')
        ->example('file.mime:text/plain')
        ->description('Asserts that the input is a file and its MIME type is one of the given MIME types.'),

];

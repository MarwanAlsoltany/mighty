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

    'string.charset' => (new Rule())
        ->name('string.charset')
        ->arguments(['array'])
        ->callback(function (mixed $input, array $charsets): bool {
            if (!is_string($input)) {
                return false;
            }

            // Starting from PHP 8.2 using Base64, HTML-Entities, HTML-Entities, Quoted-Printable encodings with mb_* functions
            // is deprecated (see https://php.watch/versions/8.2/mbstring-qprint-base64-uuencode-html-entities-deprecated),
            // the mb_list_encodings() will return all availabe encodings including the deprecated ones but
            // mb_encoding_aliases($encoding) will trigger a deprecation when these encodings are passed to it.
            // We need to clean the result of mb_list_encodings() from these encodings to before passing them to any mb_* function.
            // Apparently, mb_list_encodings() returns these deprecated encodings as the first elements in the list
            // we cloud simply array_slice(mb_list_encodings(), 3), but this is not relayable, as the order may change without a notice.
            $encodings  = mb_list_encodings();
            $encodings  = array_udiff($encodings, ['Base64', 'HTML-Entities', 'Uuencode', 'Quoted-Printable'], strcasecmp(...));
            $encodings  = array_map(fn ($encoding) => [$encoding, ...mb_encoding_aliases($encoding)], $encodings);
            $encodings  = array_merge(...((array)$encodings));
            $encodings  = array_unique($encodings);
            $available  = array_map(strtoupper(...), $encodings);
            $charsets   = array_map(strtoupper(...), $charsets);
            $difference = array_diff($charsets, $available);

            if (empty($charsets) === true || empty($difference) === false) {
                return false;
            }

            $encoding = mb_detect_encoding($input, $charsets, true);
            $result   = in_array($encoding, $charsets);

            return $result;
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be encoded in one of the following charsets: ${@arguments.0}.')
        ->example('string.charset:UTF-8')
        ->description('Asserts that the input is encoded in one of the given charsets (aliases included). The check is done in a case-sensitive manner.'),

    'string.contains' => (new Rule())
        ->name('string.contains')
        ->arguments(['string', 'bool'])
        ->callback(fn (mixed $input, string $needle, bool $strict = false): bool => is_string($input) && ($strict ? 'strpos' : 'stripos')($input, $needle) !== false)
        ->parameters(['@input', '@arguments.0', '@arguments.1'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must contain: ${@arguments.0}.')
        ->example('string.contains:substring')
        ->description('Asserts that the input contains the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).'),

    'string.startsWith' => (new Rule())
        ->name('string.startsWith')
        ->arguments(['string', 'bool'])
        ->callback(fn (mixed $input, string $needle, bool $strict = false): bool => is_string($input) && ($strict ? 'strpos' : 'stripos')($input, $needle, 0) === 0)
        ->parameters(['@input', '@arguments.0', '@arguments.1'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must start with: ${@arguments.0}.')
        ->example('string.startsWith:substring,1')
        ->description('Asserts that the input starts with the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).'),

    'string.endsWith' => (new Rule())
        ->name('string.endsWith')
        ->arguments(['string', 'bool'])
        ->callback(fn (mixed $input, string $needle, bool $strict = false): bool => is_string($input) && ($strict ? 'strrpos' : 'strripos')($input, $needle, 0) === (strlen($input) - strlen($needle)))
        ->parameters(['@input', '@arguments.0', '@arguments.1'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must end with: ${@arguments.0}.')
        ->example('string.endsWith:substring,0')
        ->description('Asserts that the input ends with the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).'),

    'string.length' => (new Rule())
        ->name('string.length')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $count): bool => is_string($input) && strlen($input) == $count)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be exactly ${@arguments.0} characters.')
        ->example('string.length:3')
        ->description('Asserts that the input is a string that is exactly the given length.'),

    'string.wordsCount' => (new Rule())
        ->name('string.wordsCount')
        ->arguments(['int'])
        ->callback(fn (mixed $input, int $count): bool => is_string($input) && str_word_count($input) == $count)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must have exactly ${@arguments.0} words.')
        ->example('string.wordsCount:3')
        ->description('Asserts that the input is a string containing exactly the given count of words.'),

];

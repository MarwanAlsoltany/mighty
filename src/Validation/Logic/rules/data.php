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
use MAKS\Mighty\Exception;

return [

    'serialized' => (new Rule())
        ->name('serialized')
        ->callback(function (mixed $input): bool {
            if (!is_string($input)) {
                return false;
            }

            $data = null;

            try {
                Exception::handle(function () use ($input, &$data) {
                    $data = unserialize($input);
                });
            } catch (\Throwable) {
                return false;
            }

            return serialize($data) === $input;
        })
        ->message('${@label} must be a valid PHP serialized data.')
        ->example('serialized')
        ->description('Asserts that the input is a valid PHP serialized data.'),

    'json' => (new Rule())
        ->name('json')
        ->callback(function (mixed $input): bool {
            if (!is_string($input)) {
                return false;
            }

            try {
                json_decode($input, false, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                return false;
            }

            return true;
        })
        ->message('${@label} must be a valid JSON.')
        ->example('json')
        ->description('Asserts that the input is a valid JSON.'),

    'base64' => (new Rule())
        ->name('base64')
        ->callback(function (mixed $input): bool {
            if (!is_string($input)) {
                return false;
            }

            $data = base64_decode($input, true);
            $isValid = $data && base64_encode($data) === $input;

            return $isValid;
        })
        ->message('${@label} must be a valid Base64 encoded string.')
        ->example('base64')
        ->description('Asserts that the input is a valid Base64 encoded string.'),

    'xml' => (new Rule())
        ->name('xml')
        ->callback(function (mixed $input): bool {
            if (!is_string($input)) {
                return false;
            }

            libxml_clear_errors();
            $xmlErrs = libxml_use_internal_errors(true);
            $element = simplexml_load_string(trim($input));
            libxml_use_internal_errors($xmlErrs);
            libxml_clear_errors();

            $isValid = $element !== false;

            return $isValid;
        })
        ->message('${@label} must be a valid XML.')
        ->example('xml')
        ->description('Asserts that the input is a valid XML.'),

    'regex' => (new Rule())
        ->name('regex')
        ->callback(function (mixed $input): bool {
            if (!is_string($input)) {
                return false;
            }

            set_error_handler(fn ($code) => $code, E_WARNING);
            $isValid = preg_match($input, '') !== false;
            restore_error_handler();

            return $isValid;
        })
        ->parameters(['@input'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a valid regular expression.')
        ->example('regex')
        ->description('Asserts that the input is a valid regular expression.'),

];

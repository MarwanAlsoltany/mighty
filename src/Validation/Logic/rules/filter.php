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

    'booleanLike' => (new Rule())
        ->name('booleanLike')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE])
        ->comparison(['@output', '!==', null])
        ->message('${@label} must be a value that can be parsed as a boolean (TRUE: true, "true", "1", "on", "yes"; FALSE: false, "false", "0", "off", "no", "", null).')
        ->example('booleanLike')
        ->description('Asserts that the input is a value that can be parsed as a boolean (TRUE: true, "true", "1", "on", "yes"; FALSE: false, "false", "0", "off", "no", "", null).'),

    'integerLike' => (new Rule())
        ->name('integerLike')
        ->arguments(['int', 'int'])
        ->callback(function (mixed $input, int $min, int $max, Rule $rule): bool {
            $rule->setVariables([
                // the ?: operator is not used because 0 is a valid value for $min and $max
                // a check is used instead to see if an argument was specifed for the rule
                // or not to determine whether or not to use the fallback values instead
                '@extra' => [
                    'min' => $min = strpos($rule->getStatement(), ':') !== false ? $min : PHP_INT_MIN,
                    'max' => $max = strpos($rule->getStatement(), ',') !== false ? $max : PHP_INT_MAX,
                ],
            ] + ($rule->getVariables() ?? []));

            $result = filter_var($input, FILTER_VALIDATE_INT, [
                'default' => false,
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max,
                ],
                'flags' => FILTER_FLAG_NONE,
            ]);

            return $result !== false;
        })
        ->parameters(['@input', '@arguments.0', '@arguments.1', '@rule'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a value that can be parsed as an integer and within ${@extra.min} to ${@extra.max} range.')
        ->example('integerLike:0,100')
        ->description('Asserts that the input is a value that can be parsed as an integer within the specifed range.'),

    'integerLike.allowOctal' => (new Rule())
        ->name('integerLike.allowOctal')
        ->arguments(['int', 'int'])
        ->callback(function (mixed $input, int $min, int $max, Rule $rule): bool {
            $rule->setVariables([
                '@extra' => [
                    'min' => $min = strpos($rule->getStatement(), ':') !== false ? $min : PHP_INT_MIN,
                    'max' => $max = strpos($rule->getStatement(), ',') !== false ? $max : PHP_INT_MAX,
                ],
            ] + ($rule->getVariables() ?? []));

            $result = filter_var($input, FILTER_VALIDATE_INT, [
                'default' => false,
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max,
                ],
                'flags' => FILTER_FLAG_ALLOW_OCTAL,
            ]);

            return $result !== false;
        })
        ->parameters(['@input', '@arguments.0', '@arguments.1', '@rule'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a value that can be parsed as an integer and within ${@extra.min} to ${@extra.max} range and can be in octal notation.')
        ->example('integerLike.allowOctal:0,100')
        ->description('Asserts that the input is a value that can be parsed as an integer within the specifed range and can be in octal notation.'),

    'integerLike.allowHex' => (new Rule())
        ->name('integerLike.allowHex')
        ->arguments(['int', 'int'])
        ->callback(function (mixed $input, int $min, int $max, Rule $rule): bool {
            $rule->setVariables([
                '@extra' => [
                    'min' => $min = strpos($rule->getStatement(), ':') !== false ? $min : PHP_INT_MIN,
                    'max' => $max = strpos($rule->getStatement(), ',') !== false ? $max : PHP_INT_MAX,
                ],
            ] + ($rule->getVariables() ?? []));

            $result = filter_var($input, FILTER_VALIDATE_INT, [
                'default' => false,
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max,
                ],
                'flags' => FILTER_FLAG_ALLOW_HEX,
            ]);

            return $result !== false;
        })
        ->parameters(['@input', '@arguments.0', '@arguments.1', '@rule'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a value that can be parsed as an integer and within ${@extra.min} to ${@extra.max} range and can be in hexadecimal notation.')
        ->example('integerLike.allowHex:0,100')
        ->description('Asserts that the input is a value that can be parsed as an integer within the specifed range and can be in hexadecimal notation.'),

    'floatLike' => (new Rule())
        ->name('floatLike')
        ->arguments(['float', 'float'])
        ->callback(function (mixed $input, float $min, float $max, Rule $rule): bool {
            $rule->setVariables([
                '@extra' => [
                    'min' => $min = strpos($rule->getStatement(), ':') !== false ? $min : PHP_FLOAT_MIN,
                    'max' => $max = strpos($rule->getStatement(), ',') !== false ? $max : PHP_FLOAT_MAX,
                ],
            ] + ($rule->getVariables() ?? []));

            $result = filter_var($input, FILTER_VALIDATE_FLOAT, [
                'default' => false,
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max,
                ],
                'flags' => FILTER_FLAG_NONE,
            ]);

            return $result !== false;
        })
        ->parameters(['@input', '@arguments.0', '@arguments.1', '@rule'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a value that can be parsed as a float and within ${@extra.min} to ${@extra.max} range.')
        ->example('floatLike:1.0,100.0')
        ->description('Asserts that the input is a value that can be parsed as a float within the specifed range.'),

    'floatLike.allowThousands' => (new Rule())
        ->name('floatLike.allowThousands')
        ->arguments(['float', 'float'])
        ->callback(function (mixed $input, float $min, float $max, Rule $rule): bool {
            $rule->setVariables([
                '@extra' => [
                    'min' => $min = strpos($rule->getStatement(), ':') !== false ? $min : PHP_FLOAT_MIN,
                    'max' => $max = strpos($rule->getStatement(), ',') !== false ? $max : PHP_FLOAT_MAX,
                ],
            ] + ($rule->getVariables() ?? []));

            $result = filter_var($input, FILTER_VALIDATE_FLOAT, [
                'default' => false,
                'options' => [
                    'min_range' => $min,
                    'max_range' => $max,
                ],
                'flags' => FILTER_FLAG_ALLOW_THOUSAND,
            ]);

            return $result !== false;
        })
        ->parameters(['@input', '@arguments.0', '@arguments.1', '@rule'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a value that can be parsed as a float and within ${@extra.min} to ${@extra.max} range.')
        ->example('floatLike.allowThousands:1.0,100.0')
        ->description('Asserts that the input is a value that can be parsed as a float within the specifed range.'),

    'regexp' => (new Rule())
        ->name('regexp')
        ->arguments(['string'])
        ->callback(function (mixed $input, string $regexp): bool {
            $result = filter_var($input, FILTER_VALIDATE_REGEXP, [
                'default' => false,
                'options' => ['regexp' => $regexp],
                'flags'   => FILTER_FLAG_NONE,
            ]);

            return $result !== false;
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must match the regex pattern ${@arguments.0}.')
        ->example('regexp:"/[a-z]/i"')
        ->description('Asserts that the input matches a Perl-compatible regular expression.'),

    'ip' => (new Rule())
        ->name('ip')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_IP])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an IP address.')
        ->example('ip')
        ->description('Asserts that the input is an IP address.'),

    'ip.v4' => (new Rule())
        ->name('ip.v4')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_IP, FILTER_FLAG_IPV4])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an IPv4 address.')
        ->example('ip.v4')
        ->description('Asserts that the input is an IPv4 address.'),

    'ip.v6' => (new Rule())
        ->name('ip.v6')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_IP, FILTER_FLAG_IPV6])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an IPv6 address.')
        ->example('ip.v6')
        ->description('Asserts that the input is an IPv6 address.'),

    'ip.notReserved' => (new Rule())
        ->name('ip.notReserved')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an IP address not within reserved IPs range.')
        ->example('ip.notReserved')
        ->description('Asserts that the input is an IP address not within reserved IPs range.'),

    'ip.notPrivate' => (new Rule())
        ->name('ip.notPrivate')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an IP address not within private IPs range.')
        ->example('ip.notPrivate')
        ->description('Asserts that the input is an IP address not within private IPs range.'),

    'mac' => (new Rule())
        ->name('mac')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_MAC, FILTER_FLAG_NONE])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a MAC address.')
        ->example('mac')
        ->description('Asserts that the input is a MAC address.'),

    'url' => (new Rule())
        ->name('url')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_URL, FILTER_FLAG_NONE])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a URL.')
        ->example('url')
        ->description('Asserts that the input is a URL.'),

    'url.withPath' => (new Rule())
        ->name('url.withPath')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a URL that contains a path.')
        ->example('url.withPath')
        ->description('Asserts that the input is a URL that contains a path.'),

    'url.withQuery' => (new Rule())
        ->name('url.withQuery')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a URL that contains a query.')
        ->example('url.withQuery')
        ->description('Asserts that the input is a URL that contains a query.'),

    'email' => (new Rule())
        ->name('email')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_EMAIL, FILTER_FLAG_NONE])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an email address.')
        ->example('email')
        ->description('Asserts that the input is an email address.'),

    'email.withUnicode' => (new Rule())
        ->name('email.withUnicode')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be an email address (unicode allowed).')
        ->example('email.withUnicode')
        ->description('Asserts that the input is an email address (unicode allowed).'),

    'domain' => (new Rule())
        ->name('domain')
        ->callback('filter_var')
        ->parameters(['@input', FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a domain.')
        ->example('domain')
        ->description('Asserts that the input is a domain.'),

    'domain.isActive' => (new Rule())
        ->name('domain.isActive')
        ->callback(function (mixed $input): bool {
            if (!is_string($input)) {
                return false;
            }

            $domain = trim(substr($input, intval(strpos($input, '@'))), '@');

            if ($domain === '') {
                // gethostbyname() returns an IP for empty strings
                return false;
            }

            return gethostbyname($domain) !== $domain;
        })
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an active domain.')
        ->example('domain.isActive')
        ->description('Asserts that the input is an active domain. Works with domains and emails.'),

];

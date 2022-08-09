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

    'ssn' => (new Rule())
        ->name('ssn')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::SSN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid SSN (US Social Security Number).')
        ->example('ssn')
        ->description('Asserts that the input is a valid SSN (US Social Security Number).'),

    'sin' => (new Rule())
        ->name('sin')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::SIN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid SIN (CA Social Insurance Number).')
        ->example('sin')
        ->description('Asserts that the input is a valid SIN (CA Social Insurance Number).'),

    'nino' => (new Rule())
        ->name('nino')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::NINO])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid NINO (UK National Insurance Number).')
        ->example('nino')
        ->description('Asserts that the input is a valid NINO (UK National Insurance Number).'),

    'vin' => (new Rule())
        ->name('vin')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::VIN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid VIN (Vehicle Identification Number).')
        ->example('vin')
        ->description('Asserts that the input is a valid VIN (Vehicle Identification Number).'),

    'issn' => (new Rule())
        ->name('issn')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::ISSN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid ISSN (International Standard Serial Number).')
        ->example('issn')
        ->description('Asserts that the input is a valid ISSN (International Standard Serial Number).'),

    'isin' => (new Rule())
        ->name('isin')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::ISIN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid ISIN (International Securities Identification Number).')
        ->example('isin')
        ->description('Asserts that the input is a valid ISIN (International Securities Identification Number).'),

    'isbn' => (new Rule())
        ->name('isbn')
        ->arguments(['string'])
        ->callback(function (mixed $input, ?string $type): bool {
            $key     = trim('isbn.' . strtolower(strval($type)), '.');
            $pattern = Regex::PATTERNS[$key] ?? Regex::ISBN;

            return is_string($input) && preg_match($pattern, $input);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid ISBN ${@arguments.0:10/13} (International Standard Book Number).')
        ->example('isbn')
        ->description('Asserts that the input is a valid ISBN (International Standard Book Number). The type (10/13) can be specifed to narrow the pattern.'),

    'imei' => (new Rule())
        ->name('imei')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::IMEI])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid IMEI (International Mobile Station Equipment Identity Number).')
        ->example('imei')
        ->description('Asserts that the input is a valid IMEI (International Mobile Station Equipment Identity Number).'),

    'imei.sv' => (new Rule())
        ->name('imei.sv')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::IMEI_SV])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid IMEI-SV (International Mobile Station Equipment Identity and Software Version Number).')
        ->example('imei.sv')
        ->description('Asserts that the input is a valid IMEI-SV (International Mobile Station Equipment Identity and Software Version Number).'),

    'meid' => (new Rule())
        ->name('meid')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::MEID])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid MEID (Mobile Equipment Identifier).')
        ->example('meid')
        ->description('Asserts that the input is a valid MEID (Mobile Equipment Identifier).'),

    'esn' => (new Rule())
        ->name('esn')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::ESN])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid ESN (Electronic Serial Number).')
        ->example('esn')
        ->description('Asserts that the input is a valid ESN (Electronic Serial Number).'),

];

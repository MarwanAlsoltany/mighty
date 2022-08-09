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

    'currency' => (new Rule())
        ->name('currency')
        ->arguments(['bool'])
        ->callback(fn (mixed $input, ?bool $numeric = false): bool => is_string($input) && ($pattern = $numeric ? Regex::CURRENCY_NUM : Regex::CURRENCY_ALPHA) && preg_match($pattern, $input))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a valid currency code.')
        ->example('currency')
        ->description('Asserts that the input is a valid currency code (default: "ISO 4217 alpha"; numeric: "ISO 4217 numeric").'),

    'currency.name' => (new Rule())
        ->name('currency.name')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CURRENCY_NAME])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a valid currency name.')
        ->example('currency.name')
        ->description('Asserts that the input is a valid currency name (as in ISO 4217).'),

    'creditcard' => (new Rule())
        ->name('creditcard')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard')
        ->description('Asserts that the input is a valid credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.visa' => (new Rule())
        ->name('creditcard.visa')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_VISA])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid Visa credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.visa')
        ->description('Asserts that the input is a valid Visa credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.mastercard' => (new Rule())
        ->name('creditcard.mastercard')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_MASTERCARD])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid Mastercard credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.mastercard')
        ->description('Asserts that the input is a valid Mastercard credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.discover' => (new Rule())
        ->name('creditcard.discover')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_DISCOVER])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid Discover credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.discover')
        ->description('Asserts that the input is a valid Discover credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.americanExpress' => (new Rule())
        ->name('creditcard.americanExpress')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_AMERICAN_EXPRESS])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid American Express credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.americanExpress')
        ->description('Asserts that the input is a valid American Express credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.dinersClub' => (new Rule())
        ->name('creditcard.dinersClub')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_DINERS_CLUB])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid Diners Club credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.dinersClub')
        ->description('Asserts that the input is a valid Diners Club credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.jcb' => (new Rule())
        ->name('creditcard.jcb')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_JCB])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid JCB credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.jcb')
        ->description('Asserts that the input is a valid JCB credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.maestro' => (new Rule())
        ->name('creditcard.maestro')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_MAESTRO])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid Maestro credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.maestro')
        ->description('Asserts that the input is a valid Maestro credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.chinaUnionPay' => (new Rule())
        ->name('creditcard.chinaUnionPay')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_CHINA_UNIONPAY])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid China UnionPay credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.chinaUnionPay')
        ->description('Asserts that the input is a valid China UnionPay credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.instaPayment' => (new Rule())
        ->name('creditcard.instaPayment')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_INSTAPAYMENT])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid InstaPayment credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.instaPayment')
        ->description('Asserts that the input is a valid InstaPayment credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.laser' => (new Rule())
        ->name('creditcard.laser')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_LASER])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid Laser credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.laser')
        ->description('Asserts that the input is a valid Laser credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.uatp' => (new Rule())
        ->name('creditcard.uatp')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_UATP])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid UATP credit card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.uatp')
        ->description('Asserts that the input is a valid UATP credit card number, balanced spaces and/or dashes are allowed.'),

    'creditcard.mir' => (new Rule())
        ->name('creditcard.mir')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CREDITCARD_MIR])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid MIR Payment System card number, balanced spaces and/or dashes are allowed.')
        ->example('creditcard.mir')
        ->description('Asserts that the input is a valid MIR Payment System card number, balanced spaces and/or dashes are allowed.'),

    'cvv' => (new Rule())
        ->name('cvv')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::CVV])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid CVV (Card Security Code).')
        ->example('cvv')
        ->description('Asserts that the input is a valid CVV (Card Security Code).'),

    'bic' => (new Rule())
        ->name('bic')
        ->callback(fn (mixed $input, string $pattern): bool => is_string($input) && preg_match($pattern, $input))
        ->parameters(['@input', Regex::BIC])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid BIC (Bank Identifier Code).')
        ->example('bic')
        ->description('Asserts that the input is a valid BIC (Bank Identifier Code).'),

    'iban' => (new Rule())
        ->name('iban')
        ->arguments(['string'])
        ->callback(function (mixed $input, ?string $country): bool {
            if (!is_string($input)) {
                return false;
            }

            $key     = trim('iban.' . strtolower(strval($country)), '.');
            $pattern = Regex::PATTERNS[$key] ?? Regex::IBAN;
            $input   = strtr($input, ['-' => '', ' ' => '']);

            return preg_match($pattern, $input) === 1;
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must be a valid ${@arguments.0:standardized} IBAN (International Bank Account Number).')
        ->example('iban:IQ')
        ->description('Asserts that the input is a valid IBAN (International Bank Account Number). The "ISO 3166-1 alpha-2" country code can be specifed to narrow the pattern.'),

];

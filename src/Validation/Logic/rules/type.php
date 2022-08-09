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

    'null' => (new Rule())
        ->name('null')
        ->callback('is_null')
        ->message('${@label} must be null.')
        ->example('null')
        ->description('Asserts that the input is null.'),

    'boolean' => (new Rule())
        ->name('boolean')
        ->callback('is_bool')
        ->message('${@label} must be a boolean.')
        ->example('boolean')
        ->description('Asserts that the input is a boolean.'),

    'integer' => (new Rule())
        ->name('integer')
        ->callback('is_int')
        ->message('${@label} must be an integer.')
        ->example('integer')
        ->description('Asserts that the input is an integer.'),

    'float' => (new Rule())
        ->name('float')
        ->callback('is_float')
        ->message('${@label} must be a float.')
        ->example('float')
        ->description('Asserts that the input is a float.'),

    'numeric' => (new Rule())
        ->name('numeric')
        ->callback('is_numeric')
        ->message('${@label} must be numeric.')
        ->example('numeric')
        ->description('Asserts that the input is numeric.'),

    'string' => (new Rule())
        ->name('string')
        ->callback('is_string')
        ->message('${@label} must be a string.')
        ->example('string')
        ->description('Asserts that the input is a string.'),

    'scalar' => (new Rule())
        ->name('scalar')
        ->callback('is_scalar')
        ->message('${@label} must be a scalar.')
        ->example('scalar')
        ->description('Asserts that the input is a scalar.'),

    'array' => (new Rule())
        ->name('array')
        ->callback('is_array')
        ->message('${@label} must be an array.')
        ->example('array')
        ->description('Asserts that the input is an array.'),

    'object' => (new Rule())
        ->name('object')
        ->callback('is_object')
        ->message('${@label} must be an object.')
        ->example('object')
        ->description('Asserts that the input is an object.'),

    'callable' => (new Rule())
        ->name('callable')
        ->callback('is_callable')
        ->message('${@label} must be a callable.')
        ->example('callable')
        ->description('Asserts that the input is a callable.'),

    'iterable' => (new Rule())
        ->name('iterable')
        ->callback('is_iterable')
        ->message('${@label} must be an iterable.')
        ->example('iterable')
        ->description('Asserts that the input is an iterable.'),

    'countable' => (new Rule())
        ->name('countable')
        ->callback('is_countable')
        ->message('${@label} must be a countable.')
        ->example('countable')
        ->description('Asserts that the input is a countable.'),

    'resource' => (new Rule())
        ->name('resource')
        ->callback('is_resource')
        ->message('${@label} must be a resource.')
        ->example('resource')
        ->description('Asserts that the input is a resource.'),

    'type' => (new Rule())
        ->name('type')
        ->arguments(['array'])
        ->callback(function (mixed $input, array $types): bool {
            $type    = strtolower(gettype($input));
            $types   = array_map('strtolower', $types);
            $aliases = [
                'integer' => 'int',
                'double' => 'float',
                'boolean' => 'bool',
            ];

            return (bool)(in_array($type, $types) || in_array($aliases[$type] ?? uniqid(), $types));
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be on of the following type(s): ${@arguments.0}.')
        ->example('type:\'["int","float"]\'')
        ->description('Asserts that the input is one of the given types.'),

    'type.debug' => (new Rule())
        ->name('type.debug')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $type): bool => get_debug_type($input) === $type)
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be on of the following type: ${@arguments.0}.')
        ->example('type.debug:string')
        ->description('Asserts that the input is of the given type using get_debug_type().'),

];

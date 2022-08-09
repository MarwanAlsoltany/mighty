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

    'object.hasProperty' => (new Rule())
        ->name('object.hasProperty')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $property): bool => is_object($input) && property_exists($input, $property))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must have the property: ${@arguments.0}.')
        ->example('object.hasProperty:property')
        ->description('Asserts that the input has the given property.'),

    'object.hasMethod' => (new Rule())
        ->name('object.hasMethod')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $method): bool => is_object($input) && method_exists($input, $method))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must have the method: ${@arguments.0}.')
        ->example('object.hasMethod:method')
        ->description('Asserts that the input has the given method.'),

    'object.isStringable' => (new Rule())
        ->name('object.isStringable')
        ->callback(fn (mixed $input): bool => is_object($input) && method_exists($input, '__toString'))
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must implement __toString() method.')
        ->example('object.isStringable')
        ->description('Asserts that the input implements __toString() method.'),

    'object.isInstanceOf' => (new Rule())
        ->name('object.isInstanceOf')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $class): bool => is_object($input) && is_a($input, $class, false))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an instance of ${@arguments.0}.')
        ->example('object.isInstanceOf:\Namespace\Class')
        ->description('Asserts that the input is an instance of the given class.'),

    'object.isSubclassOf' => (new Rule())
        ->name('object.isSubclassOf')
        ->arguments(['string'])
        ->callback(fn (mixed $input, string $class): bool => is_object($input) && is_subclass_of($input, $class, false))
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be an subclass of ${@arguments.0}.')
        ->example('object.isSubclassOf:\Namespace\Class')
        ->description('Asserts that the input is a subclass of the given class.'),

];

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

    'if' => (new Rule())
        ->name('if')
        ->arguments(['mixed', 'mixed', 'string'])
        ->callback(function (Rule $rule, mixed $actual, mixed $expected = true, string $operator = '=='): bool {
            // expected can be a null (desired) or a null resulting from not specifying it at all
            // the check is done here to see if it was not provided to use the fallback instead
            if (empty($expected) && strpos($rule->getStatement(), ',') === false) {
                $expected = true;
            }
            // operator is optional
            if (empty($operator)) {
                $operator = '==';
            }

            $rule->setVariables([
                '@extra' => compact('actual', 'expected', 'operator'),
            ] + ($rule->getVariables() ?? []));

            $assert = Inspector::OPERATIONS[$operator] ?? Inspector::OPERATIONS['=='];
            $result = $assert($actual, $expected);

            return $result;
        })
        ->parameters(['@rule', '@arguments.0', '@arguments.1', '@arguments.2'])
        ->comparison(['@output', '===', true])
        ->message('Falsy condition: [${@extra.actual} ${@extra.operator} ${@extra.expected}].')
        ->example('if:7,7,==')
        ->description('Checks the condition between the first argument and the second argument, the condition operator can also be specified as the third argument.'),

    'if.eq' => (new Rule())
        ->name('if.eq')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'eq', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must be equal to ${@arguments.1}.')
        ->example('if.eq:3,3')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is "==".'),

    'if.neq' => (new Rule())
        ->name('if.neq')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'neq', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must not be equal to ${@arguments.1}.')
        ->example('if.neq:1,2')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is "!=".'),

    'if.id' => (new Rule())
        ->name('if.id')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'id', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must be identical to ${@arguments.1}.')
        ->example('if.id:3,3')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is "===".'),

    'if.nid' => (new Rule())
        ->name('if.nid')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'nid', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must not be identical to ${@arguments.1}.')
        ->example('if.nid:1,2')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is "!==".'),

    'if.gt' => (new Rule())
        ->name('if.gt')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'gt', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must be greater than ${@arguments.1}.')
        ->example('if.gt:2,1')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is ">".'),

    'if.gte' => (new Rule())
        ->name('if.gte')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'gte', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must be greater than or equal to ${@arguments.1}.')
        ->example('if.gte:2,2')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is ">=".'),

    'if.lt' => (new Rule())
        ->name('if.lt')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'lt', '@arguments.1'])
        ->message('Falsy condition: ${@arguments.0} must be less than {@arguments.1}.')
        ->example('if.lt:1,2')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is "<".'),

    'if.lte' => (new Rule())
        ->name('if.lte')
        ->arguments(['mixed', 'mixed'])
        ->comparison(['@arguments.0', 'lte', '@arguments.1'])
        ->message('Falsy condition: {@arguments.0} must be less than or equal to {@arguments.1}.')
        ->example('if.lte:1,2')
        ->description('Checks the condition between the first argument and the second argument, the condition operator is "<=".'),

];

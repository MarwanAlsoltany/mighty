<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Logic;

return [

    'bool' => 'boolean',

    'int' => 'integer',

    'long' => 'integer',

    'double' => 'float',

    'real' => 'float',

    'str' => 'string',

    'arr' => 'array',

    'obj' => 'object',

    'stream' => 'resource',

    'assert' => 'if',

    'assert.equals' => 'if.eq',

    'assert.notEquals' => 'if.neq',

    'assert.greaterThan' => 'if.gt',

    'assert.greaterThanOrEquals' => 'if.gte',

    'assert.lessThan' => 'if.lt',

    'assert.lessThanOrEquals' => 'if.lte',

    'blank' => 'empty',

    'is' => 'equals',

    'same' => 'equals',

    'pattern' => 'matches',

    'choice' => 'in',

    'size' => 'count',

    'length' => 'count',

    'range' => 'between',

    'minmax' => 'between',

    'filled' => 'required',

    'present' => 'required',

    'optional' => 'allowed',

    'date' => 'datetime',

    'date.equals' => 'datetime.eq',

    'date.before' => 'datetime.lt',

    'date.beforeOrEquals' => 'datetime.lte',

    'date.after' => 'datetime.gt',

    'date.afterOrEquals' => 'datetime.gte',

    'date.format' => 'datetime.format',

    'cakeday' => 'datetime.birthday',

];

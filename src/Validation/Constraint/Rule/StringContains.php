<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Constraint\Rule;

use Attribute;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint\Rule;

/**
 * Adds `string.contains` rule. Asserts that the input contains the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).
 *
 * This is an auto-generated class that was generated programmatically by:
 * `MAKS\Mighty\Maker`
 *
 * @package Mighty\Validator
 *
 * @codeCoverageIgnore There is nothing to test here. The underlying code is fully tested.
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class StringContains extends Rule
{
    public const NAME = 'string.contains';

    public function __construct(string $substring, bool $strict = false, ?string $message = null, Strategy $strategy = Strategy::FailLazy)
    {
        $arguments = array_slice(func_get_args(), 0, 2);

        parent::__construct(name: self::NAME, arguments: $arguments, message: $message, strategy: $strategy);
    }
}

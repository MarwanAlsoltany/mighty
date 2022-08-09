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
 * Adds `array.subset` rule. Asserts that the input is an array that contains the given subset. Note that this check applies only to the first dimension of the array.
 *
 * This is an auto-generated class that was generated programmatically by:
 * `MAKS\Mighty\Validation\Maker`
 *
 * @package Mighty\Validator
 *
 * @codeCoverageIgnore There is nothing to test here. The underlying code is fully tested.
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class ArraySubset extends Rule
{
    public const NAME = 'array.subset';

    public function __construct(array $subset, ?string $message = null, Strategy $strategy = Strategy::FailLazy)
    {
        $arguments = array_slice(func_get_args(), 0, 1);

        parent::__construct(name: self::NAME, arguments: $arguments, message: $message, strategy: $strategy);
    }
}

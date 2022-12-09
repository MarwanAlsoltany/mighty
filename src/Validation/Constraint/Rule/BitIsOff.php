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
 * Adds `bit.isOff` rule. Asserts that the input is a turned off bit (equals: false, 0 or "0").
 *
 * This is an auto-generated class that was generated programmatically by:
 * `MAKS\Mighty\Maker`
 *
 * @package Mighty\Validator
 *
 * @codeCoverageIgnore There is nothing to test here. The underlying code is fully tested.
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
final class BitIsOff extends Rule
{
    public const NAME = 'bit.isOff';

    public function __construct(?string $message = null, Strategy $strategy = Strategy::FailLazy)
    {
        $arguments = array_slice(func_get_args(), 0, 0);

        parent::__construct(name: self::NAME, arguments: $arguments, message: $message, strategy: $strategy);
    }
}

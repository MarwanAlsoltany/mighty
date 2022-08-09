<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation;

use UnitEnum;
use BackedEnum;

/**
 * Provides helpers to unit and backed enums to cast and retrieve names and values in a unified interface.
 *
 * @package Mighty\Validator
 *
 * @codeCoverageIgnore The logic here is pretty straightforward.
 */
trait SmartEnum
{
    /**
     * @return array<string>
     */
    public static function names(): array
    {
        $array = [];
        $cases = self::cases();

        foreach ($cases as $case) {
            $array[] = $case->name;
        }

        return $array;
    }

    /**
     * @return array<string|int>
     */
    public static function values(): array
    {
        $array = [];
        $cases = self::cases();

        foreach ($cases as $case) {
            /** @var UnitEnum|BackedEnum $case */
            $array[] = match (true) {
                $case instanceof BackedEnum => $case->value,
                $case instanceof UnitEnum   => $case->name,
            };
        }

        return $array;
    }

    /**
     * @return array<string,string|int>
     */
    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    public function toScalar(): string|int
    {
        if ($this instanceof BackedEnum) {
            return $this->value;
        }

        return $this->name;
    }
}

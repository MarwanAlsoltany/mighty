<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Support;

/**
 * Inspector class.
 *
 * @internal
 * @package Mighty\Validator
 *
 * @codeCoverageIgnore
 */
final class Inspector
{
    public const OPERATIONS = [
        '=='  => [self::class, 'isEqual'],
        'eq'  => [self::class, 'isEqual'],
        '!='  => [self::class, 'isNotEqual'],
        '<>'  => [self::class, 'isNotEqual'],
        'neq' => [self::class, 'isNotEqual'],
        '===' => [self::class, 'isIdentical'],
        'id'  => [self::class, 'isIdentical'],
        '!==' => [self::class, 'isNotIdentical'],
        'nid' => [self::class, 'isNotIdentical'],
        '<'   => [self::class, 'isLessThan'],
        'lt'  => [self::class, 'isLessThan'],
        '<='  => [self::class, 'isLessThanOrEqual'],
        'lte' => [self::class, 'isLessThanOrEqual'],
        '>'   => [self::class, 'isGreaterThan'],
        'gt'  => [self::class, 'isGreaterThan'],
        '>='  => [self::class, 'isGreaterThanOrEqual'],
        'gte' => [self::class, 'isGreaterThanOrEqual'],
        '<=>' => [self::class, 'doSpaceship'],
        'sps' => [self::class, 'doSpaceship'],
        '!'   => [self::class, 'doNegate'],
        '&&'  => [self::class, 'doAnd'],
        'and' => [self::class, 'doAnd'],
        '||'  => [self::class, 'doOr'],
        'or'  => [self::class, 'doOr'],
        'xor' => [self::class, 'doXor'],
        '~'   => [self::class, 'doBitwiseNegate'],
        '&'   => [self::class, 'doBitwiseAnd'],
        '|'   => [self::class, 'doBitwiseOr'],
        '^'   => [self::class, 'doBitwiseXor'],
        '<<'  => [self::class, 'doBitwiseShiftLeft'],
        '>>'  => [self::class, 'doBitwiseShiftRight'],
    ];


    /**
     * Checks if `$value1` and `$value2` are equal using the `==` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isEqual(mixed $value1, mixed $value2): bool
    {
        return ($value1 == $value2);
    }

    /**
     * Checks if `$value1` and `$value2` are not equal using the `!=` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isNotEqual(mixed $value1, mixed $value2): bool
    {
        return ($value1 != $value2);
    }

    /**
     * Checks if `$value1` and `$value2` are identical using the `===` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isIdentical(mixed $value1, mixed $value2): bool
    {
        return ($value1 === $value2);
    }

    /**
     * Checks if `$value1` and `$value2` are not identical using the `!==` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isNotIdentical(mixed $value1, mixed $value2): bool
    {
        return ($value1 !== $value2);
    }

    /**
     * Checks if `$value1` is less than `$value2` using the `<` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isLessThan(mixed $value1, mixed $value2): bool
    {
        return ($value1 < $value2);
    }

    /**
     * Checks if `$value1` is less than or equal to `$value2` using the `<=` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isLessThanOrEqual(mixed $value1, mixed $value2): bool
    {
        return ($value1 <= $value2);
    }

    /**
     * Checks if `$value1` is greater than `$value2` using the `>` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isGreaterThan(mixed $value1, mixed $value2): bool
    {
        return ($value1 > $value2);
    }

    /**
     * Checks if `$value1` is greater than or equal to `$value2` using the `>=` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function isGreaterThanOrEqual(mixed $value1, mixed $value2): bool
    {
        return ($value1 >= $value2);
    }

    /**
     * Performs a SPACESHIP on the passed values using the `<=>` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return int
     */
    public static function doSpaceship(mixed $value1, mixed $value2): int
    {
        return ($value1 <=> $value2);
    }


    /**
     * Negates the passed value using the `!` operator.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function doNegate($value): bool
    {
        return !($value);
    }

    /**
     * Performs a logical AND on the passed values using the `&&` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function doAnd(mixed $value1, mixed $value2): bool
    {
        return ($value1 && $value2);
    }

    /**
     * Performs a logical OR on the passed values using the `||` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function doOr(mixed $value1, mixed $value2): bool
    {
        return ($value1 || $value2);
    }

    /**
     * Performs a logical XOR on the passed values using the `xor` operator.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function doXor(mixed $value1, mixed $value2): bool
    {
        return ($value1 xor $value2);
    }


    /**
     * Negates the passed value using the `~` bitwise operator.
     *
     * @param null|bool|int|float|string $value
     *
     * @return int
     */
    public static function doBitwiseNegate(null|bool|int|float|string $value): int
    {
        return ~((int)$value);
    }

    /**
     * Performs a bitwise AND on the passed values using the `&` operator.
     *
     * @param null|bool|int|float|string $value1
     * @param null|bool|int|float|string $value2
     *
     * @return int
     */
    public static function doBitwiseAnd(null|bool|int|float|string $value1, null|bool|int|float|string $value2): int
    {
        return ($value1 & $value2);
    }

    /**
     * Performs a bitwise OR on the passed values using the `|` operator.
     *
     * @param null|bool|int|float|string $value1
     * @param null|bool|int|float|string $value2
     *
     * @return int
     */
    public static function doBitwiseOr(null|bool|int|float|string $value1, null|bool|int|float|string $value2): int
    {
        return ($value1 | $value2);
    }

    /**
     * Performs a bitwise XOR on the passed values using the `^` operator.
     *
     * @param null|bool|int|float|string $value1
     * @param null|bool|int|float|string $value2
     *
     * @return int
     */
    public static function doBitwiseXor(null|bool|int|float|string $value1, null|bool|int|float|string $value2): int
    {
        return ($value1 ^ $value2);
    }

    /**
     * Performs a bitwise shift left on the passed values using the `<<` operator.
     *
     * @param null|bool|int|float|string $value1
     * @param null|bool|int|float|string $value2
     *
     * @return int
     */
    public static function doBitwiseShiftLeft(null|bool|int|float|string $value1, null|bool|int|float|string $value2): int
    {
        return ($value1 << $value2);
    }

    /**
     * Performs a bitwise shift right on the passed values using the `>>` operator.
     *
     * @param null|bool|int|float|string $value1
     * @param null|bool|int|float|string $value2
     *
     * @return int
     */
    public static function doBitwiseShiftRight(null|bool|int|float|string $value1, null|bool|int|float|string $value2): int
    {
        return ($value1 >> $value2);
    }


    /**
     * Determines whether a variable is empty or not.
     *
     * The variable can be any PHP type, the check is done as follows:
     * - If the variable is a `boolean` or numeric (`integer`, `float`, `string`), it is not considered empty even if its value equals `0`.
     * - If the variable is a `string`, it will be trimmed and checked with PHP `empty()` language construct.
     * - If the variable is any other type, it will be checked with PHP `empty()` language construct.
     *
     * @param mixed $variable
     *
     * @return bool
     */
    public static function isEmpty(mixed $variable): bool
    {
        if (is_bool($variable)) {
            return false;
        }

        if (is_numeric($variable)) {
            return false;
        }

        if (is_string($variable)) {
            return empty(trim($variable));
        }

        return empty($variable);
    }

    /**
     * Returns the count of a variable.
     *
     * The variable can be any PHP type, the rules for counting are as follows:
     * - If the variable is an `array` or `countable`, the method will return the number of elements in it.
     * - If the variable is an `object`, the method will count of the accessible non-static properties of it.
     * - If the variable is a `boolean`, the method will return `1` if the variable is `true`, and `0` if it is `false`.
     * - If the variable is an `integer`, the method will return the number itself.
     * - If the variable is a `float` or a numeric string, the method will cast it to a float and returns it.
     * - If the variable is a `string` or any other type, the method will cast it to a string and returns the length of it after trimming.
     *
     * @param mixed $variable
     *
     * @return int|float
     */
    public static function getCount(mixed $variable): int|float
    {
        if (is_countable($variable)) {
            return count($variable);
        }

        if (is_object($variable)) {
            return count(get_object_vars($variable));
        }

        if (is_bool($variable)) {
            return intval($variable);
        }

        if (is_numeric($variable)) {
            return floatval($variable);
        }

        return mb_strlen(trim(strval($variable)));
    }

    /**
     * Returns the passed value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function return(mixed $value): mixed
    {
        return $value;
    }
}

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
 * Serializer class.
 *
 * @package Mighty\Support
 */
class Serializer
{
    /**
     * Returns a string representation of the given variable.
     *
     * The variable will be stringified as follows:
     * - `null` -> As JSON null (`null`).
     * - `boolean` -> As JSON boolean (`true` or `false`).
     * - `integer` -> As JSON number (`123`).
     * - `float` -> As JSON number (`1.5`).
     * - `string` -> As JSON string (`"string"`).
     * - `array` -> As JSON array or object (`[1, "2", "Three"]` or `{"one": 1, "two": "2", "three": "Three"}`).
     * - `object` -> As JSON object (`{"property": "value"}`) or the result of stringifing if the object implements `__toString()`.
     *
     * NOTE: This method works in conjunction with `self::unserialize()`.
     *
     * @param mixed $variable The variable to stringify.
     *
     * @return string
     */
    public static function serialize(mixed $variable): string
    {
        if (is_object($variable) && method_exists($variable, '__toString')) {
            $variable = static::encode(strval($variable));
        } else {
            $variable = static::encode($variable);
        }

        $variable = strval($variable); // in case JSON encoding fails

        return $variable;
    }

    /**
     * Returns the passed variable and applies the given cast to it if specified.
     *
     * Available casts are:
     * - `null`
     * - `boolean` or `bool`
     * - `integer` or `int`
     * - `float` or `double`
     * - `string`
     * - `array`
     * - `object`
     *
     * NOTE: Unknown casts will return the passed variable.
     *
     * NOTE: This method works in conjunction with `self::serialize()`.
     *
     * @param string $variable The variable to cast.
     * @param string|null $cast The type to cast into. If not specifed the type will be inferred from the variable (using JSON rules).
     *
     * @return mixed
     */
    public static function unserialize(string $variable, ?string $cast = null): mixed
    {
        static $casts = null;

        if ($casts === null) {
            $casts = [
                'null'    => fn (&$var) => settype($var, 'null'),
                'bool'    => fn (&$var) => settype($var, 'boolean'),
                'boolean' => fn (&$var) => settype($var, 'boolean'),
                'int'     => fn (&$var) => settype($var, 'integer'),
                'integer' => fn (&$var) => settype($var, 'integer'),
                'float'   => fn (&$var) => settype($var, 'float'),
                'double'  => fn (&$var) => settype($var, 'float'),
                'string'  => fn (&$var) => settype($var, 'string'),
                'array'   => fn (&$var) => settype($var, 'array'),
                'object'  => fn (&$var) => settype($var, 'object'),
            ];
        }

        $variable = static::decode($variable);

        if (isset($casts[$cast = strtolower(strval($cast))])) {
            ($casts[$cast])($variable);
        }

        return $variable;
    }

    /**
     * Encodes the given value using JSON standard.
     *
     * @param mixed $value The value to encode.
     *
     * @return string
     */
    public static function encode(mixed $value): string
    {
        return strval(json_encode($value, (
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE |
            JSON_PARTIAL_OUTPUT_ON_ERROR
        )));
    }

    /**
     * Decodes the given value using JSON standard.
     *
     * @param string $value The value to decode.
     *
     * @return mixed
     */
    public static function decode(string $value): mixed
    {
        return $value === 'null' ? null : (
            json_decode($value, true) ??
            json_decode(stripslashes($value), true) ??
            json_decode(sprintf('"%s"', $value), true) ??
            $value
        );
    }
}

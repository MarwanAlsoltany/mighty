<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Support;

use MAKS\Mighty\Support\Serializer;

/**
 * Holder for various miscellaneous utility function.
 *
 * @package Mighty\Support
 */
final class Utility
{
    /**
     * Injects variables into a string containing placeholders.
     * Placeholder must match: `/(\$\{(?:@?[a-z0-9]+[a-z0-9_\-\.]*+)(?::.+?)?\})/i`.
     *
     * @param string $string The string to inject the values into.
     *      The placeholders will be simply replaced with their corresponding values.
     *      The syntax for the placeholder is `{@someKey}`, or `{@someKey:fallback}` to provide a fallback value.
     *      Fallbacks are used if the value of the provided key does not exist, equals `null`, or an empty string `''`.
     *      Note that type casting is applied when injecting the values (see `Serializer::serialize()` for the expected results).
     * @param array<string,mixed> $variables The variables to get the values from to replace placeholders with their corresponding values.
     *      To be able to retrieve object properties (or an object within the passed array),
     *      pass the `$variables` to `self::castToArray()` before passing it to this function.
     *
     * @return string The final string with the variables injected.
     */
    public static function injectInString(string $string, array $variables): string
    {
        if (empty($string) || empty($variables)) {
            return $string;
        }

        $placeholder = '/(?<injectables>\$\{(?:@?[a-z0-9]+[a-z0-9_\-\.]*+)(?::.+?)?\})/i';
        $injectables = preg_match_all($placeholder, $string, $matches);
        $injectables = $injectables ? $matches['injectables'] : [];

        // replace the variables in the string
        foreach ($injectables as $injectable) {
            $parts    = explode(':', trim($injectable, '{$}'), 2);
            $key      = $parts[0];
            $fallback = $parts[1] ?? null;

            $variable = self::getArrayValue($variables, $key);
            $variable = self::getInjectionVariable($variable, $fallback);
            $variable = Serializer::serialize($variable);

            // if the placeholder is wrapped with double quotes
            // it needs to be escaped to minimize CSV enclosure collisions
            $escapable = strpos($string, "'{$injectable}'") !== false;
            $variable  = $escapable ? addcslashes($variable, "'") : $variable;

            $string = strtr($string, [$injectable => $variable]);
        }

        return $string;
    }

    /**
     * Injects variables into an array containing placeholders as values.
     * Placeholder must match: `/^((?:@?[a-z0-9]+[a-z0-9_\-\.]*)(?::.+?)?)$/i`.
     *
     * @param array<int|string,mixed> $array An array containing elements,
     *      where their values are strings for a key (in dot notation) in the passed variables.
     *      The syntax for the placeholder is `@someKey`, or `@someKey:fallback` to provide a fallback value.
     *      Fallbacks are used if the value of the provided key does not exist, equals `null`, or an empty string `''`.
     *      Note that no type casting is applied when injecting the values.
     * @param array<int|string,mixed> $variables The variables to get the values from to replace placeholders with their corresponding values.
     *      To be able to retrieve object properties (or an object within the passed array),
     *      pass the `$variables` to `self::castToArray()` before passing it to this function.
     *
     * @return array<int|string,mixed> The final array with the values injected.
     */
    public static function injectInArray(array $array, array $variables): array
    {
        if (empty($array) || empty($variables)) {
            return $array;
        }

        $placeholder = '/^(?<injectables>(?:@?[a-z0-9]+[a-z0-9_\-\.]*)(?::.+?)?)$/i';
        $injectables = preg_grep($placeholder, $array) ?: [];

        // for some reason, preg_grep() matches true, and numbers as well
        // apparently, preg_grep() casts all values under the hood to strings
        // this makes no sense and is probably a bug in preg_grep()
        // so these values need to be filtered out, only strings are kept
        $injectables = array_filter($injectables, 'is_string');

        foreach ($injectables as $index => $injectable) {
            $parts    = explode(':', $injectable, 2);
            $key      = $parts[0];
            $fallback = $parts[1] ?? null;

            $variable = self::getArrayValue($variables, $key);
            $variable = self::getInjectionVariable($variable, $fallback);

            $array[$index] = $variable;
        }

        return $array;
    }

    /**
     * Determines whether the variable or the fallback should be used and returns it.
     * The fallback is returned if the `$variable` is `null` or `''` (empty string); and `$fallback` is not `null`.
     *
     * @param mixed $variable The variable to use.
     * @param string|null $fallback The fallback to use.
     *
     * @return mixed The value to inject.
     */
    private static function getInjectionVariable(mixed $variable, ?string $fallback): mixed
    {
        if ($fallback !== null && ($variable === null || $variable === '')) {
            return $fallback;
        }

        return $variable;
    }

    /**
     * Expands array wildcards by injecting the necessary keys from the available keys in the passed data.
     *
     * @param array<mixed> $array The array with keys containing `*` in their dot notation representation.
     * @param array<mixed> $data The data to retrieve the wildcards from.
     *
     * @return array<mixed> The final array with the keys expanded.
     */
    public static function expandArrayWildcards(array $array, array $data): array
    {
        foreach ($array as $key => $value) {
            $key = strval($key);

            if (strpos($key, '*') === false) {
                continue;
            }

            if ($key === '*') {
                $clone  = $data;
                $result = array_walk($clone, fn (&$item) => $item = is_object($value) ? clone $value : $value);
                $array  = array_replace_recursive($clone, $array);

                unset($array[$key], $result);

                continue;
            }

            [$before, $after] = explode('*', $key, 2);
            [$before, $after] = [rtrim($before, '.'), ltrim($after, '.')];

            $content = self::getArrayValue($data, $before, $value);
            $inserts = [];

            foreach ((array)$content as $nested => $_) {
                $wildcard = is_array($content) ? $nested : ''; // scalar values shouldn't become arrays
                $expanded = trim(sprintf('%s.%s.%s', $before, $wildcard, $after), '.');
                $value    = is_object($value) ? clone $value : $value;
                $insert   = [$expanded => $value];

                // keep expanding if key still have wildcards
                while (strpos((string)key($insert), '*') !== false) {
                    $insert = self::expandArrayWildcards($insert, $data);
                }

                $inserts[] = $insert;
            }

            // build the final array and insert
            // the expanded keys in their right position
            $keys   = array_keys($array);
            $offset = array_search($key, $keys);
            $head   = array_slice($array, 0, $offset = intval($offset));
            $tail   = array_slice($array, $offset);
            $count  = array_unshift($inserts, $head);
            $count  = array_push($inserts, $tail);
            $array  = array_merge(...$inserts);

            unset($array[$key], $count);
        }

        return $array;
    }

    /**
     * Retrieves a value from an array via dot notation.
     *
     * NOTE: Keys are allowed to have dots in them.
     * NOTE: Keys with dots in their names have precedence over nested array.
     *
     * @param array<int|string,mixed> $array The array to get the value from.
     *      To be able to retrieve object properties (or an object within the passed array),
     *      pass the `$array` to `self::castToArray()` before passing it to this function.
     * @param string $key The key to the value.
     * @param mixed $fallback The fallback value to return if the key has no value or null.
     *
     * @return mixed The actual value or the fallback value.
     */
    public static function getArrayValue(array $array, string $key, $fallback = null): mixed
    {
        /*
         * this function will check for a key from right to left  to allow for retrieving
         * array values via dot notation even when they have dots in their keys
         *
         * it does that by going first from right-to-left using the passed key
         * and then it goes one level deeper from left-to-right if it encounters a nested array
         * this process of alternating is repeated as many time as needed until a value is found
         *
         * this approach is used instead of typical array reference implementation
         * to allow for retrieving values via dot notation that have dots in their keys
         * it is also about 3x faster than using a recursive iterator which will flatten
         * the keys but be short of the ability of returning a nested array (entire array)
         *
         * example:
         *
         * $array = ['a' => ['b' => ['c.d' => 'e']]];
         * getArrayValue($array, 'a') # will return ['b' => ['c.d' => 'e']]
         * getArrayValue($array, 'a.b') # will return ['c.d' => 'e']
         * getArrayValue($array, 'a.b.c') # will return fallback (null)
         * getArrayValue($array, 'a.b.c.d') # will return 'e'
         *
         * it works as follows (check out the numbers to see the search flow):
         *
         * (A) . (B) . (C) . (D)
         * 001 . 001 . 001 . 001   [<--] (right-to-left)
         * 003 . 003 . 003 . 002   [<--] (right-to-left)
         * 005 . 005 . 004 . 004   [<--] (right-to-left)
         * 006 . 007 . 007 . 007   [-->] (left-to-right)
         * 008 . 008 . 009 . 009   [-->] (left-to-right)
         *
         * (A) . (B) . (C) . (D)
         * _____________________   [<--] (RTL: $array['a.b.c.d'])
         * _______________ . ___   [<--] (RTL: $array['a.b.c']['d'])
         * _________ . _________   [<--] (RTL: $array['a.b']['c.d'])
         * ___ . _______________   [-->] (LTR: $array['a']['b.c.d'])
         * _________ . _________   [-->] (LTR: $array['a']['b']['c.d'])
         */

        // return immediately if the array is empty
        if (empty($array)) {
            return $fallback;
        }

        // $rtlKey is the current right-to-left key
        // gets passed as a parameter and is update with each call
        $rtlKey = $key;
        // $ltrKey is the current left-to-right key
        // used in recursion and is updated only when and as needed
        static $ltrKey = null;

        if ($ltrKey === null) {
            $ltrKey = $key;
        }

        // if the key does not have dots
        if (strpos($ltrKey, '.') === false) {
            // try to get a value
            $value = $array[$ltrKey] ?? $fallback;

            // clear recursion cache
            $ltrKey = null;

            return $value;
        }

        // check the validity of the RTL key
        // and discard it as needed
        // so go one level higher in the key
        if (isset($array[$rtlKey]) === false) {
            // shorten the key before going higher (right-to-left)
            $rtlKey = substr($rtlKey, 0, strrpos($rtlKey, '.') ?: 0);

            // return immediately if the key is empty
            if (empty($rtlKey)) {
                // clear recursion cache
                $ltrKey = null;

                // return the fallback value
                return $fallback;
            }

            // repeat this step as needed
            return self::getArrayValue($array, $rtlKey, $fallback);
        }

        // by now all invalid RTL keys are gone
        // this case is for keys that have dots
        // but point to a none nested array
        if (strcmp($rtlKey, $ltrKey) === 0) {
            // try to get a value
            $value = $array[$key] ?? $fallback;

            // clear recursion cache
            $ltrKey = null;

            return $value;
        }

        // by now all invalid RTL keys are gone
        // the array can only have a nested key
        // so go one level deeper in the array

        // shorten the key before going deeper (left-to-right)
        $rest = substr($ltrKey, strlen($rtlKey) + 1);

        // update recursion cache
        $ltrKey = $rest;

        // repeat this step as needed
        return self::getArrayValue($array[$rtlKey], $rest, $fallback);
    }

    /**
     * Casts any variable (including objects) to an array recursively.
     *
     * If the variable is an object or has an object as one of its items,
     * the returned array will contain all public, protected, and private
     * properties of the object as an associative array without prefixing.
     *
     * NOTE: This method is not recursive as in recalling the method as many times as needed.
     *      It uses iteration (uses 1 recursion stack frame) and leverages references and pointers
     *      instead of using copies, this makes the casting super fast, very efficient and consistent.
     *
     * @param mixed $variable The variable to cast to an array.
     *
     * @return mixed[]
     */
    public static function castToArray(mixed $variable): array
    {
        // cast the variable to an array to make it iterable
        // this variable will always reference the current iteration array
        $array = (array)($variable);
        // recursion stack (references of iteration arrays)
        $stack = [&$array];
        // reference to the top of the stack (final result)
        $final = &$stack[0];
        // references for array that have keys that need fixing
        $fixes = [];

        // iterate over the array recursively
        while (!empty($stack)) {
            $depth = count($stack) - 1; // current depth of the stack
            $array = &$stack[$depth] ?? null; // current iteration array

            /** @var array|null $array */
            if ($array === null) {
                // stack is empty, noting to iterate over anymore
                break;
            }

            $key = key($array); // current key of the iteration array

            if ($key === null) {
                // iteration array is empty or array pointer reached the end
                unset($stack[$depth]); // pop the recursion stack
                reset($array); // reset array internal pointer

                continue;
            }

            $key   = strval($key); // cast key to string for consistency
            $new   = strrchr($key, "\0") ?: $key; // discard object property visibility prefix
            $new   = trim($new); // trim whitespace nd left over null bytes from key
            $value = &$array[$key]; // reference to the value of the current key

            if ($key !== $new) {
                // some array key need fixing (contain visibility prefix)
                // the fixing is done outside this loop to avoid duplicates,
                // reordering, and most importantly messing array internal pointer
                $fixes[] = [&$array, [$key => $new]];
            }

            if (is_object($value) || is_array($value)) {
                // if the value is an object or array, cast it when necessary
                // and make it the current iteration array
                // the "(array)" cast is not used here because some objects
                // like \Closure are not castable to arrays but result in
                // [$value] which will make the iteration endless
                $array[$key]       = is_array($value) ? $value : get_mangled_object_vars($value);
                $stack[$depth + 1] = &$array[$key]; // update current iteration array reference
            }

            next($array); // move to the next item
        }

        // fix arrays that have keys that need fixing
        foreach ($fixes as [&$array, $keys]) {
            $oldKey = key($keys);
            $newKey = end($keys);
            $value  = &$array[$oldKey];

            // this is more efficient but does not preserve keys positions
            // $array[$newKey] = $value;
            // unset($array[$oldKey]);

            // replace array old key and preserve it position
            $keys   = array_keys($array);
            $offset = array_search($oldKey, $keys, true);
            $head   = array_slice($array, 0, $offset, true);
            $tail   = array_slice($array, 1 + $offset, null, true);
            // update current array reference
            $array  = $head + [$newKey => $value] + $tail;
        }

        return $final;
    }

    /**
     * Interpolates context values into text placeholders.
     *
     * NOTE: Interpolated values be serialized to the most human readable form (mostly as JSON).
     *
     * @param string $text The text to interpolate.
     * @param array $context An associative array like `['varName' => 'varValue']`.
     * @param string $wrapper The wrapper that indicate a variable. Max 2 chars or 0 for none, anything else will be ignored and "{}" will be used instead.
     *
     * @return string The interpolated string.
     */
    public static function interpolate(string $text, array $context = [], string $wrapper = '{}'): string
    {
        if (($length = strlen($wrapper)) && $length !== 2) {
            $wrapper = '{}';
        }

        $replacements = [];

        foreach ($context as $key => $value) {
            $placeholder = ($wrapper[0] ?? '') . $key . ($wrapper[1] ?? '');

            if (
                (is_scalar($value) || is_null($value)) ||
                (is_object($value) && method_exists($value, '__toString'))
            ) {
                $replacements[$placeholder] = strval($value === null ? 'null' : $value);

                continue;
            }

            $replacements[$placeholder] = json_encode($value);
        }

        return strtr($text, $replacements);
    }

    /**
     * Transforms the case/content of a string by applying a one or more of the 26 available transformations.
     * The transformations are applied in the fixes they are specified.
     * Available transformations:
     * - `clean`: discards all punctuations and meta-characters (@#%&$^*+-=_~:;,.?!(){}[]|/\\'"\`), separates concatenated words [`ExampleString-num.1`, `Example String num 1`].
     * - `alnum`: removes every thing other that english letters, numbers and spaces. [`Example@123` -> `Example123`]
     * - `alpha`: removes every thing other that english letters. [`Example123` -> `Example`]
     * - `numeric`: removes every thing other that numbers. [`Example123` -> `123`]
     * - `slug`: lowercase, all letters to their A-Z representation (transliteration), spaces to dashes, no special characters (URL-safe) [`Example (String)` -> `example-string`].
     * - `title`: titlecase [`example string` -> `Example String`].
     * - `sentence`: lowercase, first letter uppercase [`exampleString` -> `Example string`].
     * - `pascal`: titlecase, no spaces [`example string` -> `ExampleString`].
     * - `camel`: titlecase, no spaces, first letter lowercase [`example string` -> `exampleString`].
     * - `dot`: lowercase, spaces to dots [`Example String` -> `example.string`].
     * - `kebab`: lowercase, spaces to dashes [`Example String` -> `example-string`].
     * - `snake`: lowercase, spaces to underscores [`Example String` -> `example_string`].
     * - `constant`: uppercase, spaces to underscores [`Example String` -> `EXAMPLE_STRING`].
     * - `cobol`: uppercase, spaces to dashes [`example string` -> `EXAMPLE-STRING`].
     * - `train`: titlecase, spaces to dashes [`example string` -> `Example-String`].
     * - `lower`: lowercase (MB) [`Example String` -> `example string`].
     * - `upper`: uppercase (MB) [`Example String` -> `EXAMPLE STRING`].
     * - `spaceless`: removes any whitespaces [`Example String` -> `ExampleString`].
     * - A built-in function name from this list can also be used: `strtolower`, `strtoupper`, `lcfirst`, `ucfirst`, `ucwords`, `trim`, `ltrim`, `rtrim`.
     *
     * NOTE: Unknown transformations will be ignored silently.
     *
     * NOTE: The subject (string) loses some of its characteristics when a transformation is applied,
     * that means reversing the transformations will not guarantee getting the old subject back.
     *
     * @param string $subject The string to transform.
     * @param string ...$transformations One or more transformations to apply.
     *
     * @return string The transformed string.
     */
    public static function transform(string $subject, string ...$transformations): string
    {
        $transliterations = 'Any-Latin;Latin-ASCII;NFD;NFC;Lower();[:NonSpacing Mark:] Remove;[:Punctuation:] Remove;[:Other:] Remove;[\u0080-\u7fff] Remove;';

        static $transformers = null;
        static $functions    = null;

        if ($transformers === null) {
            $transformers = [
                'clean'     => fn ($string) => self::transform(preg_replace(['/[^\p{L}\p{N}\s]+/u', '/[\p{Lu}]+/u', '/[\s]+/'], [' ', ' $0', ' '], $string), 'trim'),
                'alnum'     => fn ($string) => self::transform(preg_replace('/[^a-zA-Z0-9 ]+/', '', $string), 'trim'),
                'alpha'     => fn ($string) => self::transform(preg_replace('/[^a-zA-Z]+/', '', $string), 'trim'),
                'numeric'   => fn ($string) => self::transform(preg_replace('/[^0-9]+/', '', $string), 'trim'),
                'slug'      => fn ($string) => self::transform(transliterator_transliterate($transliterations, preg_replace('/-+/', ' ', $string)), 'kebab'),
                'title'     => fn ($string) => self::transform($string, 'clean', 'ucwords'),
                'sentence'  => fn ($string) => self::transform($string, 'clean', 'lower', 'ucfirst'),
                'pascal'    => fn ($string) => self::transform($string, 'clean', 'lower', 'ucwords', 'spaceless'),
                'camel'     => fn ($string) => self::transform($string, 'clean', 'lower', 'ucwords', 'lcfirst', 'spaceless'),
                'dot'       => fn ($string) => strtr(self::transform($string, 'clean', 'lower'), [' ' => '.']),
                'kebab'     => fn ($string) => strtr(self::transform($string, 'clean', 'lower'), [' ' => '-']),
                'snake'     => fn ($string) => strtr(self::transform($string, 'clean', 'lower'), [' ' => '_']),
                'constant'  => fn ($string) => strtr(self::transform($string, 'clean', 'upper'), [' ' => '_']),
                'cobol'     => fn ($string) => strtr(self::transform($string, 'clean', 'upper'), [' ' => '-']),
                'train'     => fn ($string) => strtr(self::transform($string, 'clean', 'lower', 'ucwords'), [' ' => '-']),
                'lower'     => fn ($string) => mb_strtolower($string, 'UTF-8'),
                'upper'     => fn ($string) => mb_strtoupper($string, 'UTF-8'),
                'spaceless' => fn ($string) => preg_replace('/[\s]+/', '', $string),
            ];

            $functions = ['strtolower', 'strtoupper', 'lcfirst', 'ucfirst', 'ucwords', 'trim', 'ltrim', 'rtrim'];
        }

        foreach ($transformations as $transformation) {
            $name = strtolower($transformation);

            if (array_key_exists($name, $transformers)) {
                $subject = ($transformers[$name])($subject);

                continue;
            }

            if (in_array($name, $functions)) {
                $subject = ($name)($subject);
            }
        }

        return $subject;
    }
}

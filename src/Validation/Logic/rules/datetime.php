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
use MAKS\Mighty\Exception;
use MAKS\Mighty\Validation\Pattern\Regex;

return [

    'timezone' => (new Rule())
        ->name('timezone')
        ->arguments(['bool'])
        ->callback(function (mixed $input, bool $strict = false): bool {
            if (!is_string($input)) {
                return false;
            }

            $timezones = \DateTimeZone::listIdentifiers() ?: [];

            $input     = $strict ? $input : strtolower($input);
            $timezones = $strict ? $timezones : array_map('strtolower', $timezones);

            return in_array($input, $timezones);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a valid timezone identifier.')
        ->example('timezone')
        ->description('Asserts that the input is a valid timezone identifier (default: case-insensitive; strict: case-sensitive).'),

    'datetime' => (new Rule())
        ->name('datetime')
        ->callback(function (mixed $input): bool {
            if ($input instanceof \DateTimeInterface) {
                return true;
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            return strtotime(strval($input)) !== false;
        })
        ->parameters(['@input'])
        ->comparison(['@output', '!==', false])
        ->message('${@label} must be a valid date.')
        ->example('datetime')
        ->description('Asserts that the input is a valid datetime string/object.'),

    'datetime.eq' => (new Rule())
        ->name('datetime.eq')
        ->arguments(['string'])
        ->callback(function (mixed $input, mixed $date): bool {
            if ($input instanceof \DateTimeInterface) {
                return $input == (new \DateTime())->setTimestamp(strtotime($date) ?: 0);
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            $input = strtotime(strval($input)) ?: 0;
            $date  = strtotime(strval($date)) ?: 1;

            return (new \DateTime())->setTimestamp($input) == (new \DateTime())->setTimestamp($date);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be equal to ${@arguments.0}.')
        ->example('datetime.eq:"2015-01-01"')
        ->description('Asserts that the input is equal to the given datetime string.'),

    'datetime.lt' => (new Rule())
        ->name('datetime.lt')
        ->arguments(['string'])
        ->callback(function (mixed $input, mixed $date): bool {
            if ($input instanceof \DateTimeInterface) {
                return $input < (new \DateTime())->setTimestamp(strtotime($date) ?: 0);
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            $input = strtotime(strval($input)) ?: 1;
            $date  = strtotime(strval($date)) ?: 0;

            return (new \DateTime())->setTimestamp($input) < (new \DateTime())->setTimestamp($date);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be before ${@arguments.0}.')
        ->example('datetime.lt:tomorrow')
        ->description('Asserts that the input is a datetime string/object less than (before) the given datetime string.'),

    'datetime.lte' => (new Rule())
        ->name('datetime.lte')
        ->arguments(['string'])
        ->callback(function (mixed $input, mixed $date): bool {
            if ($input instanceof \DateTimeInterface) {
                return $input <= (new \DateTime())->setTimestamp(strtotime($date) ?: 0);
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            $input = strtotime(strval($input)) ?: 1;
            $date  = strtotime(strval($date)) ?: 0;

            return (new \DateTime())->setTimestamp($input) <= (new \DateTime())->setTimestamp($date);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be before or equal to ${@arguments.0}.')
        ->example('datetime.lte:tomorrow')
        ->description('Asserts that the input is a datetime string/object less than (before) or equal to the given datetime string.'),

    'datetime.gt' => (new Rule())
        ->name('datetime.gt')
        ->arguments(['string'])
        ->callback(function (mixed $input, mixed $date): bool {
            if ($input instanceof \DateTimeInterface) {
                return $input > (new \DateTime())->setTimestamp(strtotime($date) ?: 0);
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            $input = strtotime(strval($input)) ?: 0;
            $date  = strtotime(strval($date)) ?: 1;

            return (new \DateTime())->setTimestamp($input) > (new \DateTime())->setTimestamp($date);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be after ${@arguments.0}.')
        ->example('datetime.gt:today')
        ->description('Asserts that the input is a datetime string/object greater than (after) the given datetime string.'),

    'datetime.gte' => (new Rule())
        ->name('datetime.gte')
        ->arguments(['string'])
        ->callback(function (mixed $input, mixed $date): bool {
            if ($input instanceof \DateTimeInterface) {
                return $input >= (new \DateTime())->setTimestamp(strtotime($date) ?: 0);
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            $input = strtotime(strval($input)) ?: 0;
            $date  = strtotime(strval($date)) ?: 1;

            return (new \DateTime())->setTimestamp($input) >= (new \DateTime())->setTimestamp($date);
        })
        ->parameters(['@input', '@arguments.0'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be after or equal to ${@arguments.0}.')
        ->example('datetime.gte:today')
        ->description('Asserts that the input is a datetime string/object greater than (after) or equal to the given datetime string.'),

    'datetime.birthday' => (new Rule())
        ->name('datetime.birthday')
        ->callback(function (mixed $input): bool {
            if ($input instanceof \DateTimeInterface) {
                return $input->format('d/m') === (new \DateTime())->format('d/m');
            }

            if (!is_string($input) && !(is_object($input) && method_exists($input, '__toString'))) {
                return false;
            }

            $input = strtotime(strval($input)) ?: 0;

            return (new \DateTime())->setTimestamp($input)->format('d/m') == (new \DateTime())->format('d/m');
        })
        ->parameters(['@input'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must have birthday today.')
        ->example('datetime.birthday')
        ->description('Asserts that the input is a datetime string/object that has birthday today. Input should preferably be in "YYYY-MM-DD" format.'),

    'datetime.format' => (new Rule())
        ->name('datetime.format')
        ->arguments(['string'])
        ->callback(function (mixed $input, string $format): bool {
            /** @var \DateTime|null $datetime */
            $datetime = null;
            $input    = is_string($input) || is_object($input) && method_exists($input, '__toString') ? strval($input) : null;

            if ($input === null) {
                return false;
            }

            try {
                Exception::handle(function () use ($input, &$datetime) {
                    $datetime = new \DateTime($input);
                });
            } catch (\Exception) {
                return false;
            }

            return $datetime->format($format) === $input;
        })
        ->parameters(['@input', '@arguments.0:Y-m-d H:i:s'])
        ->comparison(['@output', '===', true])
        ->message('${@label} must be a valid date matching the format: ${@arguments.0}.')
        ->example('datetime.format:"Y-m-d H:i:s"')
        ->description('Asserts that the input is a valid date/time with the given format.'),

    'datetime.format.global' => (new Rule())
        ->name('datetime.format.global')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::DATETIME_FORMAT_GLOBAL])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a global datetime string as defined in the HTML5 specification.')
        ->example('datetime.format.global')
        ->description('Asserts that the input looks like a valid global datetime string as defined in the HTML5 specification.'),

    'datetime.format.local' => (new Rule())
        ->name('datetime.format.local')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::DATETIME_FORMAT_LOCAL])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a local datetime string as defined in the HTML5 specification.')
        ->example('datetime.format.local')
        ->description('Asserts that the input looks like a valid local datetime string as defined in the HTML5 specification.'),

    'datestamp' => (new Rule())
        ->name('datestamp')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::DATESTAMP])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human datestamp, DMY or MDY format, separated with dot, dash, or slash.')
        ->example('datestamp')
        ->description('Asserts that the input looks like a human datestamp, DMY or MDY format, separated with dot, dash, or slash.'),

    'datestamp.ymd' => (new Rule())
        ->name('datestamp.ymd')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::DATESTAMP_YMD])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human YMD-formatted datestamp, separated with dot, dash, or slash.')
        ->example('datestamp.ymd')
        ->description('Asserts that the input looks like a human YMD-formatted datestamp, separated with dot, dash, or slash.'),

    'datestamp.dmy' => (new Rule())
        ->name('datestamp.dmy')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::DATESTAMP_DMY])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human DMY-formatted datestamp, separated with dot, dash, or slash.')
        ->example('datestamp.dmy')
        ->description('Asserts that the input looks like a human DMY-formatted datestamp, separated with dot, dash, or slash.'),

    'datestamp.mdy' => (new Rule())
        ->name('datestamp.mdy')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::DATESTAMP_MDY])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human MDY-formatted datestamp, separated with dot, dash, or slash.')
        ->example('datestamp.mdy')
        ->description('Asserts that the input looks like a human MDY-formatted datestamp, separated with dot, dash, or slash.'),

    'timestamp' => (new Rule())
        ->name('timestamp')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::TIMESTAMP])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human timestamp, 24 or 12 hours format with or without seconds.')
        ->example('timestamp')
        ->description('Asserts that the input looks like a human timestamp, 24 or 12 hours format with or without seconds.'),

    'timestamp.12' => (new Rule())
        ->name('timestamp.12')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::TIMESTAMP_12])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human timestamp, 12 hours format with or without seconds and optional AM/PM.')
        ->example('timestamp.12')
        ->description('Asserts that the input looks like a human timestamp, 12 hours format with or without seconds and optional AM/PM.'),

    'timestamp.hms' => (new Rule())
        ->name('timestamp.hms')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::TIMESTAMP_HMS])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human timestamp, 24 or 12 hours format with seconds.')
        ->example('timestamp.hms')
        ->description('Asserts that the input looks like a human timestamp, 24 or 12 hours format with seconds.'),

    'timestamp.hm' => (new Rule())
        ->name('timestamp.hm')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::TIMESTAMP_HM])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human timestamp, 24 or 12 hours format without seconds.')
        ->example('timestamp.hm')
        ->description('Asserts that the input looks like a human timestamp, 24 or 12 hours format without seconds.'),

    'timestamp.ms' => (new Rule())
        ->name('timestamp.ms')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::TIMESTAMP_MS])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a human timestamp, containing minutes and seconds only.')
        ->example('timestamp.ms')
        ->description('Asserts that the input looks like a human timestamp, containing minutes and seconds only.'),

    'calender.day' => (new Rule())
        ->name('calender.day')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::CALENDER_DAY])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a weekday in shot or long format ("Mon" or "Monday").')
        ->example('calender.day')
        ->description('Asserts that the input looks like a calendar dayin shot or long format ("Mon" or "Monday").'),

    'calender.month' => (new Rule())
        ->name('calender.month')
        ->callback(fn (mixed $input, string $pattern): bool => (is_string($input) || is_object($input) && method_exists($input, '__toString')) && preg_match($pattern, strval($input)))
        ->parameters(['@input', Regex::CALENDER_MONTH])
        ->comparison(['@output', '!=', false])
        ->message('${@label} must look like a month in shot or long format ("Jan" or "January").')
        ->example('calender.month')
        ->description('Asserts that the input looks like a calendar month in shot or long format ("Jan" or "January").'),

];

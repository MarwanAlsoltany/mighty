<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty;

use Closure;
use MAKS\Mighty\Validator;
use MAKS\Mighty\Rule;
use MAKS\Mighty\Engine;
use MAKS\Mighty\Support\Utility;
use MAKS\Mighty\Validation\Expression;
use MAKS\Mighty\Exception\ValidationLogicException;

/**
 * Validator aware validation expression builder.
 *
 * {@inheritDoc}
 *
 * Example:
 * ```
 * $validation = (new Validation())->required()->string()->between(2, 255)->or()->null();
 *
 * $validation = Validation::required()->string()->between(2, 255)->or()->null()->build();
 * ```
 *
 *
 * Rules:
 *
 * @method static static null() Adds `null` rule. Asserts that the input is null.
 * @method static static boolean() Adds `boolean` rule. Asserts that the input is a boolean.
 * @method static static integer() Adds `integer` rule. Asserts that the input is an integer.
 * @method static static float() Adds `float` rule. Asserts that the input is a float.
 * @method static static numeric() Adds `numeric` rule. Asserts that the input is numeric.
 * @method static static string() Adds `string` rule. Asserts that the input is a string.
 * @method static static scalar() Adds `scalar` rule. Asserts that the input is a scalar.
 * @method static static array() Adds `array` rule. Asserts that the input is an array.
 * @method static static object() Adds `object` rule. Asserts that the input is an object.
 * @method static static callable() Adds `callable` rule. Asserts that the input is a callable.
 * @method static static iterable() Adds `iterable` rule. Asserts that the input is an iterable.
 * @method static static countable() Adds `countable` rule. Asserts that the input is a countable.
 * @method static static resource() Adds `resource` rule. Asserts that the input is a resource.
 * @method static static type(string|array $type) Adds `type` rule. Asserts that the input is one of the given types.
 * @method static static typeDebug(string $type) Adds `type.debug` rule. Asserts that the input is of the given type using get_debug_type().
 *
 * @method static static alpha() Adds `alpha` rule. Asserts that the input consists of alphabetic characters only.
 * @method static static alnum() Adds `alnum` rule. Asserts that the input consists of alphanumeric characters only.
 * @method static static lower() Adds `lower` rule. Asserts that the input consists of lowercase characters only.
 * @method static static upper() Adds `upper` rule. Asserts that the input consists of uppercase characters only.
 * @method static static cntrl() Adds `cntrl` rule. Asserts that the input consists of control characters only.
 * @method static static space() Adds `space` rule. Asserts that the input consists of whitespace characters only.
 * @method static static punct() Adds `punct` rule. Asserts that the input consists of punctuation characters only.
 * @method static static graph() Adds `graph` rule. Asserts that the input consists of graphic characters only (characters that create a visible output).
 * @method static static print() Adds `print` rule. Asserts that the input consists of printable characters only.
 * @method static static digit() Adds `digit` rule. Asserts that the input consists of a digits only (numeric characters).
 * @method static static xdigit() Adds `xdigit` rule. Asserts that the input represent hexadecimal digits.
 *
 * @method static static booleanLike() Adds `booleanLike` rule. Asserts that the input is value that can be parsed as a boolean (TRUE: true, "true", "1", "on", "yes"; FALSE: false, "false", "0", "off", "no", "", null).
 * @method static static integerLike(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX) Adds `integerLike` rule. Asserts that the input is a value that can be parsed as an integer within the specifed range.
 * @method static static integerLikeAllowOctal(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX) Adds `integerLike.allowOctal` rule. Asserts that the input is a value that can be parsed as an integer within the specifed range and can be in octal notation.
 * @method static static integerLikeAllowHex(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX) Adds `integerLike.allowHex` rule. Asserts that the input is a value that can be parsed as an integer within the specifed range and can be in hexadecimal notation.
 * @method static static floatLike(float $min = PHP_FLOAT_MIN, float $max = PHP_FLOAT_MAX) Adds `floatLike` rule. Asserts that the input is a value that can be parsed as a float within the specifed range.
 * @method static static floatLikeAllowThousands(float $min = PHP_FLOAT_MIN, float $max = PHP_FLOAT_MAX) Adds `floatLike.allowThousands` rule. Asserts that the input is a value that can be parsed as a float within the specifed range.
 * @method static static regexp(string $pattern) Adds `regexp` rule. Asserts that the input matches a Perl-compatible regular expression.
 * @method static static ip() Adds `ip` rule. Asserts that the input is an IP address.
 * @method static static ipV4() Adds `ip.v4` rule. Asserts that the input is an IPv4 address.
 * @method static static ipV6() Adds `ip.v6` rule. Asserts that the input is an IPv6 address.
 * @method static static ipNotReserved() Adds `ip.notReserved` rule. Asserts that the input is an IP address not within reserved IPs range.
 * @method static static ipNotPrivate() Adds `ip.notPrivate` rule. Asserts that the input is an IP address not within private IPs range.
 * @method static static mac() Adds `mac` rule. Asserts that the input is a MAC address.
 * @method static static url() Adds `url` rule. Asserts that the input is a URL.
 * @method static static urlWithPath() Adds `url.withPath` rule. Asserts that the input is a URL that contains a path.
 * @method static static urlWithQuery() Adds `url.withQuery` rule. Asserts that the input is a URL that contains a query.
 * @method static static email() Adds `email` rule. Asserts that the input is an email address.
 * @method static static emailWithUnicode() Adds `email.withUnicode` rule. Asserts that the input is an email address (unicode allowed).
 * @method static static domain() Adds `domain` rule. Asserts that the input is a domain.
 * @method static static domainIsActive() Adds `domain.isActive` rule. Asserts that the input is an active domain. Works with domains and emails.
 *
 * @method static static file() Adds `file` rule. Asserts that the input is a file (can be a file, a link, or a directory).
 * @method static static fileIsFile() Adds `file.isFile` rule. Asserts that the input is a file.
 * @method static static fileIsLink() Adds `file.isLink` rule. Asserts that the input is a link.
 * @method static static fileIsDirectory() Adds `file.isDirectory` rule. Asserts that the input is a directory.
 * @method static static fileIsExecutable() Adds `file.isExecutable` rule. Asserts that the input is a file and is executable.
 * @method static static fileIsWritable() Adds `file.isWritable` rule. Asserts that the input is a file and is writable.
 * @method static static fileIsReadable() Adds `file.isReadable` rule. Asserts that the input is a file and is readable.
 * @method static static fileIsUploaded() Adds `file.isUploaded` rule. Asserts that the input is a file that is uploaded via HTTP POST.
 * @method static static fileSize(int $sizeInBytes) Adds `file.size` rule. Asserts that the input is a file and the size is equal to the given size in bytes.
 * @method static static fileSizeLte(int $sizeInBytes) Adds `file.size.lte` rule. Asserts that the input is a file and the size is less than or equal to the given size in bytes.
 * @method static static fileSizeGte(int $sizeInBytes) Adds `file.size.gte` rule. Asserts that the input is a file and the size is greater than or equal to the given size in bytes.
 * @method static static fileDirname(string $dirname) Adds `file.dirname` rule. Asserts that the input is a file and its dirname is equal to the given dirname.
 * @method static static fileBasename(string $basename) Adds `file.basename` rule. Asserts that the input is a file and its basename is equal to the given basename.
 * @method static static fileFilename(string $filename) Adds `file.filename` rule. Asserts that the input is a file and its filename is equal to the given filename.
 * @method static static fileExtension(string $extension) Adds `file.extension` rule. Asserts that the input is a file and its extension is equal to the given extension.
 * @method static static fileMime(string|array $mine) Adds `file.mime` rule. Asserts that the input is a file and its MIME type is one of the given MIME types.
 * @method static static image() Adds `image` rule. Asserts that the input is an image file (jpg, jpeg, png, gif, bmp, svg, or webp).
 * @method static static imageWidth(int $width) Adds `image.width` rule. Asserts that the input is an image and its width is equal to the given width in pixels.
 * @method static static imageWidthLte(int $width) Adds `image.width.lte` rule. Asserts that the input is an image and its width is less than or equal to the given width in pixels.
 * @method static static imageWidthGte(int $width) Adds `image.width.gte` rule. Asserts that the input is an image and its width is greater than or equal to the given width in pixels.
 * @method static static imageHeight(int $height) Adds `image.height` rule. Asserts that the input is an image and its height is equal to the given height in pixels.
 * @method static static imageHeightLte(int $height) Adds `image.height.lte` rule. Asserts that the input is an image and its height is less than or equal to the given height in pixels.
 * @method static static imageHeightGte(int $height) Adds `image.height.gte` rule. Asserts that the input is an image and its height is greater than or equal to the given height in pixels.
 * @method static static imageDimensions(int $width, int $height, string $operator = '==') Adds `image.dimensions` rule. Asserts that the input is an image and its dimensions are less than, equal to, or greater than the given width and height in pixels.
 * @method static static imageRatio(string $ratio) Adds `image.ratio` rule. Asserts that the input is an image and its aspect ratio is equal to the given ratio (ratio must be specified like "16:9").
 *
 * @method static static if(mixed $actual, mixed $expected = true, string $operator = '==') Adds `if` rule. Checks the condition between the first argument and the second argument, the condition operator can also be specified as the third argument.
 * @method static static ifEq(mixed $actual, mixed $expected) Adds `if.eq` rule. Checks the condition between the first argument and the second argument, the condition operator is "==".
 * @method static static ifNeq(mixed $actual, mixed $expected) Adds `if.neq` rule. Checks the condition between the first argument and the second argument, the condition operator is "!=".
 * @method static static ifId(mixed $actual, mixed $expected) Adds `if.id` rule. Checks the condition between the first argument and the second argument, the condition operator is "===".
 * @method static static ifNid(mixed $actual, mixed $expected) Adds `if.nid` rule. Checks the condition between the first argument and the second argument, the condition operator is "!==".
 * @method static static ifGt(mixed $actual, mixed $expected) Adds `if.gt` rule. Checks the condition between the first argument and the second argument, the condition operator is ">".
 * @method static static ifGte(mixed $actual, mixed $expected) Adds `if.gte` rule. Checks the condition between the first argument and the second argument, the condition operator is ">=".
 * @method static static ifLt(mixed $actual, mixed $expected) Adds `if.lt` rule. Checks the condition between the first argument and the second argument, the condition operator is "<".
 * @method static static ifLte(mixed $actual, mixed $expected) Adds `if.lte` rule. Checks the condition between the first argument and the second argument, the condition operator is "<=".
 *
 * @method static static empty() Adds `empty` rule. Asserts that the input is empty using empty() language construct (is blank, i.e. empty string, empty array, false, null, or 0).
 * @method static static required() Adds `required` rule. Asserts that the input is required (is not blank, i.e. not a empty string or null).
 * @method static static allowed() Adds `allowed` rule. Asserts that the input is allowed (can be empty or have any value, null and empty string are considered valid values).
 * @method static static forbidden() Adds `forbidden` rule. Asserts that the input is forbidden (is null or not present).
 * @method static static accepted() Adds `accepted` rule. Asserts that the input is accepted (equals: "on", "yes", "yeah", "yep", "yo", "ok", "okay", "aye", 1 or "1", true or "true") note that strings are treated in a case-insensitive manner.
 * @method static static declined() Adds `declined` rule. Asserts that the input is declined (equals: "off", "no", "not", "nope", "neh", "nay", 0 or "0", false or "false") note that strings are treated in a case-insensitive manner.
 * @method static static bit() Adds `bit` rule. Asserts that the input is bit (equals: 1 or "1", true; 0 or "0", false).
 * @method static static bitIsOn() Adds `bit.isOn` rule. Asserts that the input is a turned on bit (equals: true, 1 or "1").
 * @method static static bitIsOff() Adds `bit.isOff` rule. Asserts that the input is a turned off bit (equals: false, 0 or "0").
 * @method static static equals(string|int|float|bool|null $value) Adds `equals` rule. Asserts that the input is equal to the given value. Works with scalar types and null. Comparison operator is "==".
 * @method static static matches(string $pattern) Adds `matches` rule. Asserts that the input matches the given pattern. Works with strings only.
 * @method static static in(string|int|float|bool|null ...$values) Adds `in` rule. Asserts that the input is in the given values. Works with scalar types and null.
 *
 * @method static static count(int $count) Adds `count` rule. Asserts that the input count is equal to the given value. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).
 * @method static static min(int|float $count) Adds `min` rule. Asserts that the input count is greater than or equal to the given value. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).
 * @method static static max(int|float $count) Adds `max` rule. Asserts that the input count is less than or equal to the given value. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).
 * @method static static between(int|float $min, int|float $max) Adds `between` rule. Asserts that the input count is between the given values. Works with all data types (null: 0; boolean: 0 or 1; float/integer: number value; string: characters count; array/countable: elements count; object: accessible properties count).
 *
 * @method static static numberIsPositive() Adds `number.isPositive` rule. Asserts that the input is a positive number.
 * @method static static numberIsNegative() Adds `number.isNegative` rule. Asserts that the input is a negative number.
 * @method static static numberIsEven() Adds `number.isEven` rule. Asserts that the input is an even number.
 * @method static static numberIsOdd() Adds `number.isOdd` rule. Asserts that the input is an odd number.
 * @method static static numberIsMultipleOf(float $number) Adds `number.isMultipleOf` rule. Asserts that the input is a multiple of the given number.
 * @method static static numberIsFinite() Adds `number.isFinite` rule. Asserts that the input is a finite number.
 * @method static static numberIsInfinite() Adds `number.isInfinite` rule. Asserts that the input is an infinite number.
 * @method static static numberIsNan() Adds `number.isNan` rule. Asserts that the input is a not a number.
 *
 * @method static static stringCharset(string|array $charset) Adds `string.charset` rule. Asserts that the input is encoded in one of the given charsets (aliases included). The check is done in a case-sensitive manner.
 * @method static static stringContains(string $substring, bool $strict = false) Adds `string.contains` rule. Asserts that the input contains the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).
 * @method static static stringStartsWith(string $substring, bool $strict = false) Adds `string.startsWith` rule. Asserts that the input starts with the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).
 * @method static static stringEndsWith(string $substring, bool $strict = false) Adds `string.endsWith` rule. Asserts that the input ends with the given substring. A second boolean argument can be specified to enable strict mode (case-sensitive).
 * @method static static stringLength(int $length) Adds `string.length` rule. Asserts that the input is a string that is exactly the given length.
 * @method static static stringWordsCount(int $count) Adds `string.wordsCount` rule. Asserts that the input is a string containing exactly the given count of words.
 *
 * @method static static arrayHasKey(string|int $key) Adds `array.hasKey` rule. Asserts that the input array has the given key.
 * @method static static arrayHasValue(mixed $value) Adds `array.hasValue` rule. Asserts that the input array contains the given value. Works with scalar types.
 * @method static static arrayHasDistinct(string|int $key) Adds `array.hasDistinct` rule. Asserts that the input is a multidimensional array that contains distinct values of the given key.
 * @method static static arrayIsAssociative() Adds `array.isAssociative` rule. Asserts that the input is an associative array.
 * @method static static arrayIsSequential() Adds `array.isSequential` rule. Asserts that the input is a sequential array.
 * @method static static arrayIsUnique() Adds `array.isUnique` rule. Asserts that the input array contains unique values. Works only with one-dimensional arrays.
 * @method static static arraySubset(array $subset) Adds `array.subset` rule. Asserts that the input is an array that contains the given subset. Note that this check applies only to the first dimension of the array.
 *
 * @method static static objectHasProperty(string $property) Adds `object.hasProperty` rule. Asserts that the input has the given property.
 * @method static static objectHasMethod(string $method) Adds `object.hasMethod` rule. Asserts that the input has the given method.
 * @method static static objectIsStringable() Adds `object.isStringable` rule. Asserts that the input implements __toString() method.
 * @method static static objectIsInstanceOf(string $classFQN) Adds `object.isInstanceOf` rule. Asserts that the input is an instance of the given class.
 * @method static static objectIsSubclassOf(string $classFQN) Adds `object.isSubclassOf` rule. Asserts that the input is a subclass of the given class.
 *
 * @method static static serialized() Adds `serialized` rule. Asserts that the input is a valid PHP serialized data.
 * @method static static json() Adds `json` rule. Asserts that the input is a valid JSON.
 * @method static static base64() Adds `base64` rule. Asserts that the input is a valid Base64 encoded string.
 * @method static static xml() Adds `xml` rule. Asserts that the input is a valid XML.
 *
 * @method static static locale(bool $strict = false) Adds `locale` rule. Asserts that the input is a valid locale identifier (default: [ISO 639-1] or [ISO 639-1]_[ISO 3166-1 alpha-2], case-insensitive, input is canonicalized before checking (dashes to underscores, no dots or charset); strict: [ISO 639-1] or [ISO 639-1]_[ISO 3166-1 alpha-2], case-sensitive without canonicalization.
 * @method static static language(bool $long = false) Adds `language` rule. Asserts that the input is a valid language code (default: "ISO 639-1"; long: "ISO 639-2/T").
 * @method static static country(bool $long = false) Adds `country` rule. Asserts that the input is a valid country code (default: "ISO 3166-1 alpha-2"; long: "ISO 3166-1 alpha-3").
 *
 * @method static static timezone(bool $strict = false) Adds `timezone` rule. Asserts that the input is a valid timezone identifier (default: case-insensitive; strict: case-sensitive).
 * @method static static datetime() Adds `datetime` rule. Asserts that the input is a valid datetime string/object.
 * @method static static datetimeEq(string $datetime) Adds `datetime.eq` rule. Asserts that the input is a datetime string/object equal to the given datetime string.
 * @method static static datetimeLt(string $datetime) Adds `datetime.lt` rule. Asserts that the input is a datetime string/object less than (before) the given datetime string.
 * @method static static datetimeLte(string $datetime) Adds `datetime.lte` rule. Asserts that the input is a datetime string/object less than (before) or equal to the given datetime string.
 * @method static static datetimeGt(string $datetime) Adds `datetime.gt` rule. Asserts that the input is a datetime string/object greater than (after) the given datetime string.
 * @method static static datetimeGte(string $datetime) Adds `datetime.gte` rule. Asserts that the input is a datetime string/object greater than (after) or equal to the given datetime string.
 * @method static static datetimeBirthday() Adds `datetime.birthday` rule. Asserts that the input is a datetime string/object that has birthday today. Input should preferably be in "YYYY-MM-DD" format.
 * @method static static datetimeFormat(string $format) Adds `datetime.format` rule. Asserts that the input is a valid datetime with the given format.
 * @method static static datetimeFormatGlobal() Adds `datetime.format.global` rule. Asserts that the input looks like a valid global datetime string as defined in the HTML5 specification.
 * @method static static datetimeFormatLocal() Adds `datetime.format.local` rule. Asserts that the input looks like a valid local datetime string as defined in the HTML5 specification.
 * @method static static datestamp() Adds `datestamp` rule. Asserts that the input looks like a human datestamp, DMY or MDY format, separated with dot, dash, or slash.
 * @method static static datestampYmd() Adds `datestamp.ymd` rule. Asserts that the input looks like a human YMD-formatted datestamp, separated with dot, dash, or slash.
 * @method static static datestampDmy() Adds `datestamp.dmy` rule. Asserts that the input looks like a human DMY-formatted datestamp, separated with dot, dash, or slash.
 * @method static static datestampMdy() Adds `datestamp.mdy` rule. Asserts that the input looks like a human MDY-formatted datestamp, separated with dot, dash, or slash.
 * @method static static timestamp() Adds `timestamp` rule. Asserts that the input looks like a human timestamp, 24 or 12 hours format with or without seconds.
 * @method static static timestamp12() Adds `timestamp.12` rule. Asserts that the input looks like a human timestamp, 12 hours format with or without seconds and optional AM/PM..
 * @method static static timestampHms() Adds `timestamp.hms` rule. Asserts that the input looks like a human timestamp, 24 or 12 hours format with seconds.
 * @method static static timestampHm() Adds `timestamp.hm` rule. Asserts that the input looks like a human timestamp, 24 or 12 hours format without seconds.
 * @method static static timestampMs() Adds `timestamp.ms` rule. Asserts that the input looks like a human timestamp, containing minutes and seconds only.
 * @method static static calenderDay() Adds `calender.day` rule. Asserts that the input looks like a calendar dayin shot or long format ("Mon" or "Monday").
 * @method static static calenderMonth() Adds `calender.month` rule. Asserts that the input looks like a calendar month in shot or long format ("Jan" or "January").
 *
 * @method static static username() Adds `username` rule. Asserts that the input is a valid username (between 4-32 characters, consists of letters in any case, optionally numbers, optionally one of the following characters "-_." (not consecutive), and must always start with a letter and end with a letter or number).
 * @method static static password() Adds `password` rule. Asserts that the input is a valid password (minimum 8 characters, consists of at least one small letter and one capital letter, at least one number, at least one special character, and optionally a space).
 *
 * @method static static uuid(string|int|null $version = null) Adds `uuid` rule. Asserts that the input is a valid UUID. The version (v1/v2/v3/v4/v5) can be specifed to narrow the pattern.
 * @method static static ascii() Adds `ascii` rule. Asserts that the input is a string containing only ASCII characters (ASCII compliant string).
 * @method static static slug() Adds `slug` rule. Asserts that the input is a valid slug.
 * @method static static meta() Adds `meta` rule. Asserts that the input is a string containing only meta characters (special characters) (i.e. "@, #, $, ...").
 * @method static static text() Adds `text` rule. Asserts that the input is a string containing letters and punctuation from any language.
 * @method static static words() Adds `words` rule. Asserts that the input is a string containing only words and spaces without any other character.
 * @method static static spaceless() Adds `spaceless` rule. Asserts that the input is a string containing no whitespace characters.
 * @method static static emoji() Adds `emoji` rule. Asserts that the input contains an emoji.
 * @method static static roman() Adds `roman` rule. Asserts that the input is a valid roman number.
 * @method static static phone() Adds `phone` rule. Asserts that the input is a valid phone number (supports: North America, Europe and most Asian and Middle East countries).
 * @method static static geolocation() Adds `geolocation` rule. Asserts that the input is a valid geolocation (latitude and longitude coordinates combination).
 *
 * @method static static version() Adds `version` rule. Asserts that the input is a valid semantic version number.
 *
 * @method static static amount() Adds `amount` rule. Asserts that the input contains only numbers, an optional decimal point (comma or dot), and an optional minus (used for amounts of money for example).
 * @method static static amountDollar() Adds `amount.dollar` rule. Asserts that the input is a validly formatted amount of USD, where decimal point and thousands separator are optional.
 * @method static static amountEuro() Adds `amount.euro` rule. Asserts that the input is a validly formatted amount of EUR, where decimal point and thousands separator are optional.
 *
 * @method static static color() Adds `color` rule. Asserts that the input is a valid CSS color (Color Word, HEX, HEX-Alpha, RGB, RGBA, HSL, HSLA).
 * @method static static colorHex() Adds `color.hex` rule. Asserts that the input is a valid CSS HEX color.
 * @method static static colorHexShort() Adds `color.hexShort` rule. Asserts that the input is a valid CSS 3-Char-HEX color.
 * @method static static colorHexLong() Adds `color.hexLong` rule. Asserts that the input is a valid CSS 6-Char-HEX color.
 * @method static static colorHexAlpha() Adds `color.hexAlpha` rule. Asserts that the input is a valid CSS HEX-Alpha (4 or 8 Chars) color.
 * @method static static colorRgb() Adds `color.rgb` rule. Asserts that the input is a valid CSS RGB color.
 * @method static static colorRgba() Adds `color.rgba` rule. Asserts that the input is a valid CSS RGBA color.
 * @method static static colorRgbNew() Adds `color.rgb.new` rule. Asserts that the input is a valid CSS4 RGB color.
 * @method static static colorHsl() Adds `color.hsl` rule. Asserts that the input is a valid CSS HSL color.
 * @method static static colorHsla() Adds `color.hsla` rule. Asserts that the input is a valid CSS HSLA color.
 * @method static static colorHslNew() Adds `color.hsl.new` rule. Asserts that the input is a valid CSS4 HSL color.
 * @method static static colorKeyword() Adds `color.keyword` rule. Asserts that the input is a valid CSS YYY color.
 *
 * @method static static ssn() Adds `ssn` rule. Asserts that the input is a valid SSN (Social Security Number).
 * @method static static sin() Adds `sin` rule. Asserts that the input is a valid SIN (CA Social Insurance Number).
 * @method static static nino() Adds `nino` rule. Asserts that the input is a valid NINO (UK National Insurance Number).
 * @method static static vin() Adds `vin` rule. Asserts that the input is a valid VIN (Vehicle Identification Number).
 * @method static static issn() Adds `issn` rule. Asserts that the input is a valid ISSN (International Standard Serial Number).
 * @method static static isin() Adds `isin` rule. Asserts that the input is a valid ISIN (International Securities Identification Number).
 * @method static static isbn(string|int|null $type = null) Adds `isbn` rule. Asserts that the input is a valid ISBN (International Standard Book Number). The type (10/13) can be specifed to narrow the pattern.
 * @method static static imei() Adds `imei` rule. Asserts that the input is a valid IMEI (International Mobile Station Equipment Identity Number).
 * @method static static imeiSv() Adds `imei.sv` rule. Asserts that the input is a valid IMEI-SV (International Mobile Station Equipment Identity and Software Version Number).
 * @method static static meid() Adds `meid` rule. Asserts that the input is a valid MEID (Mobile Equipment Identifier).
 * @method static static esn() Adds `esn` rule. Asserts that the input is a valid ESN (Electronic Serial Number).
 *
 * @method static static currency(bool $numeric = false) Adds `currency` rule. Asserts that the input is a valid currency code (default: "ISO 4217 alpha"; numeric: "ISO 4217 numeric").
 * @method static static currencyName() Adds `currency.name` rule. Asserts that the input is a valid currency name (as in ISO 4217).
 * @method static static creditcard() Adds `creditcard` rule. Asserts that the input is a valid credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardVisa() Adds `creditcard.visa` rule. Asserts that the input is a valid Visa credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardMastercard() Adds `creditcard.mastercard` rule. Asserts that the input is a valid Mastercard credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardDiscover() Adds `creditcard.discover` rule. Asserts that the input is a valid Discover credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardAmericanExpress() Adds `creditcard.americanExpress` rule. Asserts that the input is a valid American Express credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardDinersClub() Adds `creditcard.dinersClub` rule. Asserts that the input is a valid Diners Club credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardJcb() Adds `creditcard.jcb` rule. Asserts that the input is a valid JCB credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardMaestro() Adds `creditcard.maestro` rule. Asserts that the input is a valid Maestro credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardChinaUnionPay() Adds `creditcard.chinaUnionPay` rule. Asserts that the input is a valid China UnionPay credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardInstaPayment() Adds `creditcard.instaPayment` rule. Asserts that the input is a valid InstaPayment credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardLaser() Adds `creditcard.laser` rule. Asserts that the input is a valid Laser credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardUatp() Adds `creditcard.uatp` rule. Asserts that the input is a valid UATP credit card number, balanced spaces and/or dashes are allowed.
 * @method static static creditcardMir() Adds `creditcard.mir` rule. Asserts that the input is a valid MIR Payment System card number, balanced spaces and/or dashes are allowed.
 * @method static static cvv() Adds `cvv` rule. Asserts that the input is a valid CVV (Card Security Code).
 * @method static static bic() Adds `bic` rule. Asserts that the input is a valid BIC (Bank Identifier Code).
 * @method static static iban(?string $country = null) Adds `iban` rule. Asserts that the input is a valid IBAN (International Bank Account Number). The "ISO 3166-1 alpha-2" country code can be specifed to narrow the pattern.
 *
 * @method static static luhn() Adds `luhn` rule. Asserts that the input passes the Luhn Algorithm check. This rule is mostly used in conjunction with other rules like credit card numbers and identifiers to further check the validity of the subject.
 *
 * @method static static phpKeyword() Adds `php.keyword` rule. Asserts that the input is a PHP language Keyword.
 * @method static static phpReserved() Adds `php.reserved` rule. Asserts that the input is a PHP language reserved word.
 * @method static static phpReservedExtra() Adds `php.reserved.extra` rule. Asserts that the input is a PHP language reserved word including soft reserved words.
 *
 * @method static static regex() Adds `regex` rule. Asserts that the input is a valid regular expression.
 *
 *
 * Aliases:
 *
 * @method static static bool() Adds `bool` rule. An alias for the `boolean` rule.
 * @method static static int() Adds `int` rule. An alias for the `integer` rule.
 * @method static static long() Adds `long` rule. An alias for the `integer` rule.
 * @method static static double() Adds `double` rule. An alias for the `float` rule.
 * @method static static real() Adds `real` rule. An alias for the `float` rule.
 * @method static static str() Adds `str` rule. An alias for the `string` rule.
 * @method static static arr() Adds `arr` rule. An alias for the `array` rule.
 * @method static static obj() Adds `obj` rule. An alias for the `object` rule.
 * @method static static stream() Adds `stream` rule. An alias for the `resource` rule.
 *
 * @method static static assert(mixed $actual, mixed $expected = true, string $operator = '==') Adds `assert` rule. An alias for the `if` rule.
 * @method static static assertEquals(mixed $actual, mixed $expected) Adds `assert.equals` rule. An alias for the `if.eq` rule.
 * @method static static assertNotEquals(mixed $actual, mixed $expected) Adds `assert.notEquals` rule. An alias for the `if.neq` rule.
 * @method static static assertGreaterThan(mixed $actual, mixed $expected) Adds `assert.greaterThan` rule. An alias for the `if.gt` rule.
 * @method static static assertGreaterThanOrEquals(mixed $actual, mixed $expected) Adds `assert.greaterThanOrEquals` rule. An alias for the `if.gte` rule.
 * @method static static assertLessThan(mixed $actual, mixed $expected) Adds `assert.lessThan` rule. An alias for the `if.lt` rule.
 * @method static static assertLessThanOrEquals(mixed $actual, mixed $expected) Adds `assert.lessThanOrEquals` rule. An alias for the `if.lte` rule.
 *
 * @method static static blank() Adds `blank` rule. An alias for the `empty` rule.
 * @method static static is(mixed $value) Adds `is` rule. An alias for the `equals` rule.
 * @method static static same(mixed $value) Adds `same` rule. An alias for the `equals` rule.
 * @method static static pattern(string $pattern) Adds `pattern` rule. An alias for the `matches` rule.
 * @method static static choice(string|int|float|bool|null ...$values) Adds `choice` rule. An alias for the `in` rule.
 *
 * @method static static size(int $size) Adds `size` rule. An alias for the `count` rule.
 * @method static static length(int $count) Adds `length` rule. An alias for the `count` rule.
 * @method static static range(int|float $min, int|float $max) Adds `range` rule. An alias for the `between` rule.
 * @method static static minmax(int|float $min, int|float $max) Adds `minmax` rule. An alias for the `between` rule.
 *
 * @method static static filled() Adds `filled` rule. An alias for the `required` rule.
 * @method static static present() Adds `present` rule. An alias for the `required` rule.
 * @method static static optional() Adds `optional` rule. An alias for the `allowed` rule.
 *
 * @method static static date() Adds `date` rule. An alias for the `datetime` rule.
 * @method static static dateEquals(string $datetime) Adds `date.equals` rule. An alias for the `datetime.eq` rule.
 * @method static static dateBefore(string $datetime) Adds `date.before` rule. An alias for the `datetime.lt` rule.
 * @method static static dateBeforeOrEquals(string $datetime) Adds `date.beforeOrEquals` rule. An alias for the `datetime.lte` rule.
 * @method static static dateAfter(string $datetime) Adds `date.after` rule. An alias for the `datetime.gt` rule.
 * @method static static dateAfterOrEquals(string $datetime) Adds `date.afterOrEquals` rule. An alias for the `datetime.gte` rule.
 * @method static static dateFormat(string $format) Adds `date.format` rule. An alias for the `datetime.format` rule.
 * @method static static cakeday() Adds `cakeday` rule. An alias for the `datetime.birthday` rule.
 *
 *
 * @package Mighty\Validator
 */
class Validation extends Expression
{
    /**
     * Associated Validator instance.
     *
     * @var Validator|null
     */
    protected readonly ?Validator $validator;


    /**
     * Validation constructor.
     *
     * @param Validator|null $validator [optional] The validator instance, used to retrieve available rules from.
     *      If not specified, rule name guessing as per convention will be used instead.
     */
    public function __construct(?Validator $validator = null)
    {
        $this->validator = $validator;
    }

    /**
     * Provides rules and aliases as static class methods.
     *
     * @param string $name
     * @param mixed[] $arguments
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return static::new()->{$name}(...$arguments);
    }

    /**
     * Creates a new Validation instance that is bound to the default Validator.
     *
     * @return self
     */
    public static function new(): self
    {
        static $validator = new Validator();

        return new Validation($validator);
    }


    /**
     * Adds a validation string or object as a group to the current validation expression.
     *
     * @param string|Expression $validation Validation expression string or object.
     *
     * @return static
     */
    public function add(string|Expression $validation): static
    {
        // make sure the added expression has no behavior
        $expression = (new parent())
            ->write((string)$validation)
            ->normal()
            ->build();

        $this->open();
        $this->write($expression);
        $this->close();

        return $this;
    }

    /**
     * Writes a rule to the current validation expression that executes the passed callback.
     *
     * @param callable $callback The callback to execute.
     *      The callback will be passed the current input as the first parameter and
     *      the rule object as the second parameter. It must return a boolean as result.
     * @param string|null $id [optional] The callback id.
     *      The name (or a unique ID if not specified) will be prefixed with `callback.`
     *      to allow the possibility of providing a message for the callback on the Validator instance.
     *
     * @return static
     *
     * @throws ValidationLogicException If the `Validation::class` instance is not bound to a `Validator::class` instance.
     */
    public function callback(callable $callback, ?string $id = null): static
    {
        if ($this->validator === null) {
            throw new ValidationLogicException(
                Utility::interpolate(
                    'Cannot use a callback rule in a {validation} instance that is not bound to an instance of {validator}',
                    ['validation' => static::class, 'validator' => Validator::class]
                )
            );
        }

        $callback = $callback instanceof Closure ? $callback : Closure::fromCallable($callback);
        $id       = $id ?: md5(spl_object_hash($callback));
        $name     = sprintf('callback.%s', $id);

        $rule = (new Rule())
            ->name($name)
            ->callback($callback)
            ->parameters(['@input', '@rule']);

        $this->validator->addRule($rule);

        $this->write($name);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function createRuleStatement(string $name, array $arguments): string
    {
        $hash  = $this->getHashedName($name);
        $names = $this->getHashedNames();

        if (!isset($names[$hash])) {
            return parent::createRuleStatement($name, $arguments);
        }

        $name      = $names[$hash];
        $arguments = Engine::createRuleArguments($arguments);
        $statement = Engine::createRuleStatement($name, $arguments);

        return $statement;
    }

    /**
     * Returns a consistent hash for the rule name.
     *
     * @param string $name Rule name.
     *
     * @return string
     */
    private function getHashedName(string $name): string
    {
        return md5(Utility::transform($name, 'alnum', 'lower', 'spaceless'));
    }

    /**
     * Returns an associative array of rule names and their corresponding hashes.
     *
     * @return array<string,string>
     */
    private function getHashedNames(): array
    {
        if (!($this->validator instanceof Validator)) {
            return [];
        }

        // as this operation is expensive, the hash table is cached
        // and is created only once for each validator rules set

        /** @var array<string,array<string,string>> $cache */
        static $cache = [];

        $rules   = $this->validator->getRules();
        $aliases = $this->validator->getAliases();

        // rules/aliases are also the key for each element
        $rules   = array_keys($rules);
        $aliases = array_keys($aliases);
        $checks  = array_merge($rules, $aliases);
        // sort rules names to make cache key consistent
        sort($checks, SORT_STRING);

        // generate cache key for the hash table
        $key = md5(implode('+', $checks));

        // if cache is not yet created, create it
        if (!isset($cache[$key])) {
            $hash = [$this, 'getHashedName'];

            $checks = array_combine($checks, $checks);
            $checks = array_map($hash, $checks);
            $checks = array_flip($checks);

            $cache[$key] = $checks;
        }

        return $cache[$key];
    }
}

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Rule;

/**
 * Validation rule names and aliases constants.
 *
 * This is an auto-generated class that was generated programmatically by:
 * `MAKS\Mighty\Validation\Maker`
 *
 * @package Mighty\Validator
 */
final class Validation
{
    public const NULL                          = 'null';

    public const BOOLEAN                       = 'boolean';

    public const INTEGER                       = 'integer';

    public const FLOAT                         = 'float';

    public const NUMERIC                       = 'numeric';

    public const STRING                        = 'string';

    public const SCALAR                        = 'scalar';

    public const ARRAY                         = 'array';

    public const OBJECT                        = 'object';

    public const CALLABLE                      = 'callable';

    public const ITERABLE                      = 'iterable';

    public const COUNTABLE                     = 'countable';

    public const RESOURCE                      = 'resource';

    public const TYPE                          = 'type';

    public const TYPE_DEBUG                    = 'type.debug';

    public const ALPHA                         = 'alpha';

    public const ALNUM                         = 'alnum';

    public const LOWER                         = 'lower';

    public const UPPER                         = 'upper';

    public const CNTRL                         = 'cntrl';

    public const SPACE                         = 'space';

    public const PUNCT                         = 'punct';

    public const GRAPH                         = 'graph';

    public const PRINT                         = 'print';

    public const DIGIT                         = 'digit';

    public const XDIGIT                        = 'xdigit';

    public const BOOLEAN_LIKE                  = 'booleanLike';

    public const INTEGER_LIKE                  = 'integerLike';

    public const INTEGER_LIKE_ALLOW_OCTAL      = 'integerLike.allowOctal';

    public const INTEGER_LIKE_ALLOW_HEX        = 'integerLike.allowHex';

    public const FLOAT_LIKE                    = 'floatLike';

    public const FLOAT_LIKE_ALLOW_THOUSANDS    = 'floatLike.allowThousands';

    public const REGEXP                        = 'regexp';

    public const IP                            = 'ip';

    public const IP_V4                         = 'ip.v4';

    public const IP_V6                         = 'ip.v6';

    public const IP_NOT_RESERVED               = 'ip.notReserved';

    public const IP_NOT_PRIVATE                = 'ip.notPrivate';

    public const MAC                           = 'mac';

    public const URL                           = 'url';

    public const URL_WITH_PATH                 = 'url.withPath';

    public const URL_WITH_QUERY                = 'url.withQuery';

    public const EMAIL                         = 'email';

    public const EMAIL_WITH_UNICODE            = 'email.withUnicode';

    public const DOMAIN                        = 'domain';

    public const DOMAIN_IS_ACTIVE              = 'domain.isActive';

    public const FILE                          = 'file';

    public const FILE_IS_FILE                  = 'file.isFile';

    public const FILE_IS_LINK                  = 'file.isLink';

    public const FILE_IS_DIRECTORY             = 'file.isDirectory';

    public const FILE_IS_EXECUTABLE            = 'file.isExecutable';

    public const FILE_IS_WRITABLE              = 'file.isWritable';

    public const FILE_IS_READABLE              = 'file.isReadable';

    public const FILE_IS_UPLOADED              = 'file.isUploaded';

    public const FILE_SIZE                     = 'file.size';

    public const FILE_SIZE_LTE                 = 'file.size.lte';

    public const FILE_SIZE_GTE                 = 'file.size.gte';

    public const FILE_DIRNAME                  = 'file.dirname';

    public const FILE_BASENAME                 = 'file.basename';

    public const FILE_FILENAME                 = 'file.filename';

    public const FILE_EXTENSION                = 'file.extension';

    public const FILE_MIME                     = 'file.mime';

    public const IMAGE                         = 'image';

    public const IMAGE_WIDTH                   = 'image.width';

    public const IMAGE_WIDTH_LTE               = 'image.width.lte';

    public const IMAGE_WIDTH_GTE               = 'image.width.gte';

    public const IMAGE_HEIGHT                  = 'image.height';

    public const IMAGE_HEIGHT_LTE              = 'image.height.lte';

    public const IMAGE_HEIGHT_GTE              = 'image.height.gte';

    public const IMAGE_DIMENSIONS              = 'image.dimensions';

    public const IMAGE_RATIO                   = 'image.ratio';

    public const IF                            = 'if';

    public const IF_EQ                         = 'if.eq';

    public const IF_NEQ                        = 'if.neq';

    public const IF_ID                         = 'if.id';

    public const IF_NID                        = 'if.nid';

    public const IF_GT                         = 'if.gt';

    public const IF_GTE                        = 'if.gte';

    public const IF_LT                         = 'if.lt';

    public const IF_LTE                        = 'if.lte';

    public const EMPTY                         = 'empty';

    public const REQUIRED                      = 'required';

    public const ALLOWED                       = 'allowed';

    public const FORBIDDEN                     = 'forbidden';

    public const ACCEPTED                      = 'accepted';

    public const DECLINED                      = 'declined';

    public const BIT                           = 'bit';

    public const BIT_IS_ON                     = 'bit.isOn';

    public const BIT_IS_OFF                    = 'bit.isOff';

    public const EQUALS                        = 'equals';

    public const MATCHES                       = 'matches';

    public const IN                            = 'in';

    public const COUNT                         = 'count';

    public const MIN                           = 'min';

    public const MAX                           = 'max';

    public const BETWEEN                       = 'between';

    public const NUMBER_IS_POSITIVE            = 'number.isPositive';

    public const NUMBER_IS_NEGATIVE            = 'number.isNegative';

    public const NUMBER_IS_EVEN                = 'number.isEven';

    public const NUMBER_IS_ODD                 = 'number.isOdd';

    public const NUMBER_IS_MULTIPLE_OF         = 'number.isMultipleOf';

    public const NUMBER_IS_FINITE              = 'number.isFinite';

    public const NUMBER_IS_INFINITE            = 'number.isInfinite';

    public const NUMBER_IS_NAN                 = 'number.isNan';

    public const STRING_CHARSET                = 'string.charset';

    public const STRING_CONTAINS               = 'string.contains';

    public const STRING_STARTS_WITH            = 'string.startsWith';

    public const STRING_ENDS_WITH              = 'string.endsWith';

    public const STRING_LENGTH                 = 'string.length';

    public const STRING_WORDS_COUNT            = 'string.wordsCount';

    public const ARRAY_HAS_KEY                 = 'array.hasKey';

    public const ARRAY_HAS_VALUE               = 'array.hasValue';

    public const ARRAY_HAS_DISTINCT            = 'array.hasDistinct';

    public const ARRAY_IS_ASSOCIATIVE          = 'array.isAssociative';

    public const ARRAY_IS_SEQUENTIAL           = 'array.isSequential';

    public const ARRAY_IS_UNIQUE               = 'array.isUnique';

    public const ARRAY_SUBSET                  = 'array.subset';

    public const OBJECT_HAS_PROPERTY           = 'object.hasProperty';

    public const OBJECT_HAS_METHOD             = 'object.hasMethod';

    public const OBJECT_IS_STRINGABLE          = 'object.isStringable';

    public const OBJECT_IS_INSTANCE_OF         = 'object.isInstanceOf';

    public const OBJECT_IS_SUBCLASS_OF         = 'object.isSubclassOf';

    public const SERIALIZED                    = 'serialized';

    public const JSON                          = 'json';

    public const BASE64                        = 'base64';

    public const XML                           = 'xml';

    public const REGEX                         = 'regex';

    public const LOCALE                        = 'locale';

    public const LANGUAGE                      = 'language';

    public const COUNTRY                       = 'country';

    public const TIMEZONE                      = 'timezone';

    public const DATETIME                      = 'datetime';

    public const DATETIME_EQ                   = 'datetime.eq';

    public const DATETIME_LT                   = 'datetime.lt';

    public const DATETIME_LTE                  = 'datetime.lte';

    public const DATETIME_GT                   = 'datetime.gt';

    public const DATETIME_GTE                  = 'datetime.gte';

    public const DATETIME_BIRTHDAY             = 'datetime.birthday';

    public const DATETIME_FORMAT               = 'datetime.format';

    public const DATETIME_FORMAT_GLOBAL        = 'datetime.format.global';

    public const DATETIME_FORMAT_LOCAL         = 'datetime.format.local';

    public const DATESTAMP                     = 'datestamp';

    public const DATESTAMP_YMD                 = 'datestamp.ymd';

    public const DATESTAMP_DMY                 = 'datestamp.dmy';

    public const DATESTAMP_MDY                 = 'datestamp.mdy';

    public const TIMESTAMP                     = 'timestamp';

    public const TIMESTAMP_12                  = 'timestamp.12';

    public const TIMESTAMP_HMS                 = 'timestamp.hms';

    public const TIMESTAMP_HM                  = 'timestamp.hm';

    public const TIMESTAMP_MS                  = 'timestamp.ms';

    public const CALENDER_DAY                  = 'calender.day';

    public const CALENDER_MONTH                = 'calender.month';

    public const COLOR                         = 'color';

    public const COLOR_HEX                     = 'color.hex';

    public const COLOR_HEX_SHORT               = 'color.hexShort';

    public const COLOR_HEX_LONG                = 'color.hexLong';

    public const COLOR_HEX_ALPHA               = 'color.hexAlpha';

    public const COLOR_RGB                     = 'color.rgb';

    public const COLOR_RGBA                    = 'color.rgba';

    public const COLOR_RGB_NEW                 = 'color.rgb.new';

    public const COLOR_HSL                     = 'color.hsl';

    public const COLOR_HSLA                    = 'color.hsla';

    public const COLOR_HSL_NEW                 = 'color.hsl.new';

    public const COLOR_KEYWORD                 = 'color.keyword';

    public const USERNAME                      = 'username';

    public const PASSWORD                      = 'password';

    public const UUID                          = 'uuid';

    public const ASCII                         = 'ascii';

    public const SLUG                          = 'slug';

    public const META                          = 'meta';

    public const TEXT                          = 'text';

    public const WORDS                         = 'words';

    public const SPACELESS                     = 'spaceless';

    public const EMOJI                         = 'emoji';

    public const ROMAN                         = 'roman';

    public const PHONE                         = 'phone';

    public const GEOLOCATION                   = 'geolocation';

    public const VERSION                       = 'version';

    public const AMOUNT                        = 'amount';

    public const AMOUNT_DOLLAR                 = 'amount.dollar';

    public const AMOUNT_EURO                   = 'amount.euro';

    public const SSN                           = 'ssn';

    public const SIN                           = 'sin';

    public const NINO                          = 'nino';

    public const VIN                           = 'vin';

    public const ISSN                          = 'issn';

    public const ISIN                          = 'isin';

    public const ISBN                          = 'isbn';

    public const IMEI                          = 'imei';

    public const IMEI_SV                       = 'imei.sv';

    public const MEID                          = 'meid';

    public const ESN                           = 'esn';

    public const CURRENCY                      = 'currency';

    public const CURRENCY_NAME                 = 'currency.name';

    public const CREDITCARD                    = 'creditcard';

    public const CREDITCARD_VISA               = 'creditcard.visa';

    public const CREDITCARD_MASTERCARD         = 'creditcard.mastercard';

    public const CREDITCARD_DISCOVER           = 'creditcard.discover';

    public const CREDITCARD_AMERICAN_EXPRESS   = 'creditcard.americanExpress';

    public const CREDITCARD_DINERS_CLUB        = 'creditcard.dinersClub';

    public const CREDITCARD_JCB                = 'creditcard.jcb';

    public const CREDITCARD_MAESTRO            = 'creditcard.maestro';

    public const CREDITCARD_CHINA_UNION_PAY    = 'creditcard.chinaUnionPay';

    public const CREDITCARD_INSTA_PAYMENT      = 'creditcard.instaPayment';

    public const CREDITCARD_LASER              = 'creditcard.laser';

    public const CREDITCARD_UATP               = 'creditcard.uatp';

    public const CREDITCARD_MIR                = 'creditcard.mir';

    public const CVV                           = 'cvv';

    public const BIC                           = 'bic';

    public const IBAN                          = 'iban';

    public const LUHN                          = 'luhn';

    public const PHP_KEYWORD                   = 'php.keyword';

    public const PHP_RESERVED                  = 'php.reserved';

    public const PHP_RESERVED_EXTRA            = 'php.reserved.extra';

    public const BOOL                          = 'bool';

    public const INT                           = 'int';

    public const LONG                          = 'long';

    public const DOUBLE                        = 'double';

    public const REAL                          = 'real';

    public const STR                           = 'str';

    public const ARR                           = 'arr';

    public const OBJ                           = 'obj';

    public const STREAM                        = 'stream';

    public const ASSERT                        = 'assert';

    public const ASSERT_EQUALS                 = 'assert.equals';

    public const ASSERT_NOT_EQUALS             = 'assert.notEquals';

    public const ASSERT_GREATER_THAN           = 'assert.greaterThan';

    public const ASSERT_GREATER_THAN_OR_EQUALS = 'assert.greaterThanOrEquals';

    public const ASSERT_LESS_THAN              = 'assert.lessThan';

    public const ASSERT_LESS_THAN_OR_EQUALS    = 'assert.lessThanOrEquals';

    public const BLANK                         = 'blank';

    public const IS                            = 'is';

    public const SAME                          = 'same';

    public const PATTERN                       = 'pattern';

    public const CHOICE                        = 'choice';

    public const SIZE                          = 'size';

    public const LENGTH                        = 'length';

    public const RANGE                         = 'range';

    public const MINMAX                        = 'minmax';

    public const FILLED                        = 'filled';

    public const PRESENT                       = 'present';

    public const OPTIONAL                      = 'optional';

    public const DATE                          = 'date';

    public const DATE_EQUALS                   = 'date.equals';

    public const DATE_BEFORE                   = 'date.before';

    public const DATE_BEFORE_OR_EQUALS         = 'date.beforeOrEquals';

    public const DATE_AFTER                    = 'date.after';

    public const DATE_AFTER_OR_EQUALS          = 'date.afterOrEquals';

    public const DATE_FORMAT                   = 'date.format';

    public const CAKEDAY                       = 'cakeday';


    private function __construct()
    {
        // prevent class from being instantiated
    }
}

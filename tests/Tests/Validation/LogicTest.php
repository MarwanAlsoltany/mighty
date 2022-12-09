<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests\Validation;

use MAKS\Mighty\Validator;
use MAKS\Mighty\Validation;
use MAKS\Mighty\TestCase;

class LogicTest extends TestCase
{
    public function testNullValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::null())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::null())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::null())->getResult());
        $this->assertFalse(Validator::validateData(1.5, Validation::null())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::null())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::null())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::null())->getResult());
    }

    public function testBooleanValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(true, Validation::boolean())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::boolean())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::boolean())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::boolean())->getResult());
        $this->assertFalse(Validator::validateData(1.23, Validation::boolean())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::boolean())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::boolean())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::boolean())->getResult());
    }

    public function testIntegerValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(123, Validation::integer())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::integer())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::integer())->getResult());
        $this->assertFalse(Validator::validateData(1.23, Validation::integer())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::integer())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::integer())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::integer())->getResult());
    }

    public function testFloatValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(12.3, Validation::float())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::float())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::float())->getResult());
        $this->assertFalse(Validator::validateData(123, Validation::float())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::float())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::float())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::float())->getResult());
    }

    public function testNumericValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('123', Validation::numeric())->getResult());
        $this->assertTrue(Validator::validateData('1e5', Validation::numeric())->getResult());
        $this->assertTrue(Validator::validateData(123, Validation::numeric())->getResult());
        $this->assertTrue(Validator::validateData(1.23, Validation::numeric())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numeric())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::numeric())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::numeric())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::numeric())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::numeric())->getResult());
    }

    public function testStringValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('test', Validation::string())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::string())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::string())->getResult());
        $this->assertFalse(Validator::validateData(123, Validation::string())->getResult());
        $this->assertFalse(Validator::validateData(1.23, Validation::string())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::string())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::string())->getResult());
    }

    public function testScalarValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('test', Validation::scalar())->getResult());
        $this->assertTrue(Validator::validateData(true, Validation::scalar())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::scalar())->getResult());
        $this->assertTrue(Validator::validateData(123, Validation::scalar())->getResult());
        $this->assertTrue(Validator::validateData(1.23, Validation::scalar())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::scalar())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::scalar())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::scalar())->getResult());
    }

    public function testArrayValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([], Validation::array())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::array())->getResult());
        $this->assertFalse(Validator::validateData('test', Validation::array())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::array())->getResult());
        $this->assertFalse(Validator::validateData(false, Validation::array())->getResult());
        $this->assertFalse(Validator::validateData(123, Validation::array())->getResult());
        $this->assertFalse(Validator::validateData(1.23, Validation::array())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::array())->getResult());
    }

    public function testObjectValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(new \stdClass(), Validation::object())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::object())->getResult());
        $this->assertFalse(Validator::validateData('test', Validation::object())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::object())->getResult());
        $this->assertFalse(Validator::validateData(false, Validation::object())->getResult());
        $this->assertFalse(Validator::validateData(123, Validation::object())->getResult());
        $this->assertFalse(Validator::validateData(1.23, Validation::object())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::object())->getResult());
    }

    public function testCallableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(fn () => 'test', Validation::callable())->getResult());
        $this->assertTrue(Validator::validateData('sprintf', Validation::callable())->getResult());
        $this->assertTrue(Validator::validateData([$this, __FUNCTION__], Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData(1.5, Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::callable())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::callable())->getResult());
    }

    public function testIterableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([], Validation::iterable())->getResult());
        $this->assertTrue(Validator::validateData(new \ArrayObject([1, 2, 3]), Validation::iterable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::iterable())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::iterable())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::iterable())->getResult());
        $this->assertFalse(Validator::validateData(1.5, Validation::iterable())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::iterable())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::iterable())->getResult());
    }

    public function testCountableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([], Validation::countable())->getResult());
        $this->assertTrue(Validator::validateData(new \ArrayObject([1, 2, 3]), Validation::countable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::countable())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::countable())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::countable())->getResult());
        $this->assertFalse(Validator::validateData(1.5, Validation::countable())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::countable())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::countable())->getResult());
    }

    public function testResourceValidationRule(): void
    {
        $this->assertFalse(Validator::validateData(null, Validation::resource())->getResult());
        $this->assertTrue(Validator::validateData(fopen('php://memory', 'r+'), Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData(1.5, Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData('string', Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::resource())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::resource())->getResult());
    }

    public function testTypeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::type('null'))->getResult());
        $this->assertTrue(Validator::validateData(123, Validation::type(['integer', 'float']))->getResult());
        $this->assertTrue(Validator::validateData($this, Validation::type(['string', 'object']))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::type('array'))->getResult());
    }

    public function testtypeDebugValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::typeDebug('null'))->getResult());
        $this->assertTrue(Validator::validateData($this, Validation::typeDebug(static::class))->getResult());
        $this->assertFalse(Validator::validateData($this, Validation::typeDebug('object'))->getResult());
    }

    public function testAlphaValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('abc', Validation::alpha())->getResult());
        $this->assertFalse(Validator::validateData('123', Validation::alpha())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::alpha())->getResult());
    }

    public function testAlnumValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('abc123', Validation::alnum())->getResult());
        $this->assertFalse(Validator::validateData('abc+123', Validation::alnum())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::alnum())->getResult());
    }

    public function testLowerValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('abc', Validation::lower())->getResult());
        $this->assertFalse(Validator::validateData('ABC', Validation::lower())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::lower())->getResult());
    }

    public function testUpperValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('ABC', Validation::upper())->getResult());
        $this->assertFalse(Validator::validateData('abc', Validation::upper())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::upper())->getResult());
    }

    public function testCntrlValidationRule(): void
    {
        $this->assertTrue(Validator::validateData("\n\r\t", Validation::cntrl())->getResult());
        $this->assertFalse(Validator::validateData('xyz', Validation::cntrl())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::cntrl())->getResult());
    }

    public function testSpaceValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(" \t", Validation::space())->getResult());
        $this->assertFalse(Validator::validateData('xyz', Validation::space())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::space())->getResult());
    }

    public function testPunctValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('.,;', Validation::punct())->getResult());
        $this->assertFalse(Validator::validateData('xyz', Validation::punct())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::punct())->getResult());
    }

    public function testGraphValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('OK!', Validation::graph())->getResult());
        $this->assertFalse(Validator::validateData('  ', Validation::graph())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::graph())->getResult());
    }

    public function testPrintValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('xyz', Validation::print())->getResult());
        $this->assertFalse(Validator::validateData("\0", Validation::print())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::print())->getResult());
    }

    public function testDigitValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('123', Validation::digit())->getResult());
        $this->assertFalse(Validator::validateData('xyz', Validation::digit())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::digit())->getResult());
    }

    public function testXdigitValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('7B', Validation::xdigit())->getResult());
        $this->assertFalse(Validator::validateData('XX', Validation::xdigit())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::xdigit())->getResult());
    }

    public function testBooleanLikeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(true, Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('true', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('1', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('on', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('yes', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('false', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('0', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('off', Validation::booleanLike())->getResult());
        $this->assertTrue(Validator::validateData('no', Validation::booleanLike())->getResult());
        $this->assertFalse(Validator::validateData('xyz', Validation::booleanLike())->getResult());
    }

    public function testIntegerLikeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(123, Validation::integerLike(123, 123))->getResult());
        $this->assertTrue(Validator::validateData('123', Validation::integerLike(123, 123))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::integerLike())->getResult());
    }

    public function testIntegerLikeAllowOctalValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(0o173, Validation::integerLikeAllowOctal(123, 123))->getResult());
        $this->assertTrue(Validator::validateData('0o173', Validation::integerLikeAllowOctal(123, 123))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::integerLikeAllowOctal())->getResult());
    }

    public function testIntegerLikeAllowHexValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(0x7B, Validation::integerLikeAllowHex(123, 123))->getResult());
        $this->assertTrue(Validator::validateData('0x7B', Validation::integerLikeAllowHex(123, 123))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::integerLikeAllowHex())->getResult());
    }

    public function testFloatLikeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(12.3, Validation::floatLike())->getResult());
        $this->assertTrue(Validator::validateData('12.3', Validation::floatLike())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::floatLike())->getResult());
    }

    public function testFloatLikeAllowThousandsValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('1,234.5', Validation::floatLikeAllowThousands())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::floatLikeAllowThousands())->getResult());
    }

    public function testRegexpValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('abc123', Validation::regexp('/[[:alnum:]]/'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::regexp('/[[:alnum:]]/'))->getResult());
    }

    public function testIpValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('127.0.0.1', Validation::ip())->getResult());
        $this->assertTrue(Validator::validateData('192.168.0.1', Validation::ip())->getResult());
        $this->assertTrue(Validator::validateData('255.255.255.255', Validation::ip())->getResult());
        $this->assertFalse(Validator::validateData('256.256.256.256', Validation::ip())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ip())->getResult());
    }

    public function testIpV4ValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('127.0.0.1', Validation::ipV4())->getResult());
        $this->assertFalse(Validator::validateData('256.256.256.256', Validation::ipV4())->getResult());
        $this->assertFalse(Validator::validateData('::1', Validation::ipV4())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ipV4())->getResult());
    }

    public function testIpV6ValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('::1', Validation::ipV6())->getResult());
        $this->assertTrue(Validator::validateData('::ffff:c0a8:1', Validation::ipV6())->getResult());
        $this->assertTrue(Validator::validateData('0:0:0:0:0:ffff:c0a8:0001', Validation::ipV6())->getResult());
        $this->assertTrue(Validator::validateData('0000:0000:0000:0000:0000:ffff:c0a8:0001', Validation::ipV6())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ipV6())->getResult());
    }

    public function testIpNotReservedValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('1.1.1.1', Validation::ipNotReserved())->getResult());
        $this->assertFalse(Validator::validateData('0.0.0.0', Validation::ipNotReserved())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ipNotReserved())->getResult());
    }

    public function testIpNotPrivateValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('8.8.8.8', Validation::ipNotPrivate())->getResult());
        $this->assertFalse(Validator::validateData('10.0.0.0', Validation::ipNotPrivate())->getResult());
        $this->assertFalse(Validator::validateData('172.16.0.0', Validation::ipNotPrivate())->getResult());
        $this->assertFalse(Validator::validateData('192.168.0.0', Validation::ipNotPrivate())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ipNotPrivate())->getResult());
    }

    public function testMacValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('2C:54:91:88:C9:E3', Validation::mac())->getResult());
        $this->assertFalse(Validator::validateData('2C:54:91:88:C9:XX', Validation::mac())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::mac())->getResult());
    }

    public function testUrlValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('http://localhost', Validation::url())->getResult());
        $this->assertTrue(Validator::validateData('ftp://localhost', Validation::url())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::url())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::url())->getResult());
    }

    public function testUrlWithPathValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('http://localhost/path', Validation::urlWithPath())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::urlWithPath())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::urlWithPath())->getResult());
    }

    public function testUrlWithQueryValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('http://localhost/path?query', Validation::urlWithQuery())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::urlWithQuery())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::urlWithQuery())->getResult());
    }

    public function testEmailValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('user@domain.tld', Validation::email())->getResult());
        $this->assertFalse(Validator::validateData('user', Validation::email())->getResult());
        $this->assertFalse(Validator::validateData('domain.tld', Validation::email())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::email())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::email())->getResult());
    }

    public function testEmailWithUnicodeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('user@domain.tld', Validation::emailWithUnicode())->getResult());
        $this->assertTrue(Validator::validateData('üßér@domain.tld', Validation::emailWithUnicode())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::emailWithUnicode())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::emailWithUnicode())->getResult());
    }

    public function testDomainValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('localhost', Validation::domain())->getResult());
        $this->assertTrue(Validator::validateData('domain.tld', Validation::domain())->getResult());
        $this->assertFalse(Validator::validateData('domain tld', Validation::domain())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::domain())->getResult());
    }

    public function testDomainIsActiveValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('localhost', Validation::domainIsActive())->getResult());
        $this->assertTrue(Validator::validateData('google.com', Validation::domainIsActive())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::domainIsActive())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::domainIsActive())->getResult());
    }

    public function testFileValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::file())->getResult());
        $this->assertTrue(Validator::validateData(__DIR__, Validation::file())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::file())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::file())->getResult());
    }

    public function testFileIsLinkValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileIsFile())->getResult());
        $this->assertFalse(Validator::validateData(__DIR__, Validation::fileIsFile())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsFile())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsFile())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsFile())->getResult());

        // this is disabled for file system permissions issues
        // $link = $this->createTestLink();
        // $this->assertTrue(Validator::validateData($link, Validation::fileIsLink())->getResult());
        // $this->destroyTestLink();
        $this->assertFalse(Validator::validateData('', Validation::fileIsLink())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsLink())->getResult());
    }

    public function testFileIsExecutableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__DIR__, Validation::fileIsDirectory())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsDirectory())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsDirectory())->getResult());

        $executable = $this->getExecutableFile();
        $this->assertTrue(Validator::validateData($executable, Validation::fileIsExecutable())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsExecutable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsExecutable())->getResult());
    }

    public function testFileIsWritableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileIsWritable())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsWritable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsWritable())->getResult());
    }

    public function testFileIsReadableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileIsReadable())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsReadable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsReadable())->getResult());
    }

    public function testFileIsUploadedValidationRule(): void
    {
        $this->assertFalse(Validator::validateData(__FILE__, Validation::fileIsUploaded())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileIsUploaded())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileIsUploaded())->getResult());
    }

    public function testFileSizeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileSize(filesize(__FILE__)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileSize(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileSize(0))->getResult());
    }

    public function testFileSizeLteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileSizeLte(filesize(__FILE__)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileSizeLte(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileSizeLte(0))->getResult());
    }

    public function testFileSizeGteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileSizeGte(filesize(__FILE__)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileSizeGte(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileSizeGte(0))->getResult());
    }

    public function testDirnameValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileDirname(pathinfo(__FILE__, PATHINFO_DIRNAME)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileDirname('dirname'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileDirname('dirname'))->getResult());
    }

    public function testBasenameValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileBasename(pathinfo(__FILE__, PATHINFO_BASENAME)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileBasename('basename'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileBasename('basename'))->getResult());
    }

    public function testFilenameValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileFilename(pathinfo(__FILE__, PATHINFO_FILENAME)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileFilename('filename'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileFilename('filename'))->getResult());
    }

    public function testExtensionValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileExtension(pathinfo(__FILE__, PATHINFO_EXTENSION)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileExtension('extension'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileExtension('extension'))->getResult());
    }

    public function testFileMimeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(__FILE__, Validation::fileMime(mime_content_type(__FILE__)))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::fileMime('mime'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::fileMime('mime'))->getResult());
    }

    public function testImageValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::image())->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::image())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::image())->getResult());
    }

    public function testImageWidthValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageWidth(16))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageWidth(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageWidth(0))->getResult());
    }

    public function testImageWidthLteValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageWidthLte(17))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageWidthLte(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageWidthLte(0))->getResult());
    }

    public function testImageWidthGteValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageWidthGte(15))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageWidthGte(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageWidthGte(0))->getResult());
    }

    public function testImageHeightValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageHeight(16))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageHeight(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageHeight(0))->getResult());
    }

    public function testImageHeightLteValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageHeightLte(17))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageHeightLte(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageHeightLte(0))->getResult());
    }

    public function testImageHeightGteValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageHeightGte(15))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageHeightGte(0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageHeightGte(0))->getResult());
    }

    public function testImageDimensionsValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageDimensions(16, 16))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageDimensions(0, 0))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageDimensions(0, 0))->getResult());
    }

    public function testImageRatioValidationRule(): void
    {
        $image = $this->createTestImage();
        $this->assertTrue(Validator::validateData($image, Validation::imageRatio('1:1'))->getResult());
        $this->destroyTestImage($image);
        $this->assertFalse(Validator::validateData('', Validation::imageRatio('0:0'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imageRatio('0:0'))->getResult());
    }

    public function testTrueValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::if(true))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if('', ''))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(null, null, '==='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(true, true, '==='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(false, false, '==='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(1, 1, '==='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(1.23, 1.23, '==='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if('String1', 'String2', '!=='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if([], [], '=='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(new \stdClass(), new \stdClass(), '=='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(1, true, '=='))->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::if(0, false, '=='))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::if(0, false, '==='))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::if(1, true, '==='))->getResult());
    }

    public function testIfEqValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifEq(1, 1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifEq(1, 2))->getResult());
    }

    public function testIfNeqValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifNeq(1, 2))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifNeq(1, 1))->getResult());
    }

    public function testIfIdValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifId(1, 1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifId(1, '1'))->getResult());
    }

    public function testIfNidValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifNid(1, '1'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifNid(1, 1))->getResult());
    }

    public function testIfGtValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifGt(2, 1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifGt(1, 2))->getResult());
    }

    public function testIfGteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifGte(2, 1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifGte(1, 2))->getResult());
    }

    public function testIfLtValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifLt(1, 2))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifLt(2, 1))->getResult());
    }

    public function testIfLteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::ifLte(1, 2))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ifLte(2, 1))->getResult());
    }

    public function testEmptyValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::empty())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::empty())->getResult());
        $this->assertTrue(Validator::validateData(0, Validation::empty())->getResult());
        $this->assertTrue(Validator::validateData('', Validation::empty())->getResult());
        $this->assertTrue(Validator::validateData([], Validation::empty())->getResult());
        $this->assertFalse(Validator::validateData(true, Validation::empty())->getResult());
        $this->assertFalse(Validator::validateData(1, Validation::empty())->getResult());
        $this->assertFalse(Validator::validateData(['item'], Validation::empty())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::empty())->getResult());
    }

    public function testRequiredValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(true, Validation::required())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::required())->getResult());
        $this->assertTrue(Validator::validateData(1, Validation::required())->getResult());
        $this->assertTrue(Validator::validateData(0, Validation::required())->getResult());
        $this->assertTrue(Validator::validateData(1.0, Validation::required())->getResult());
        $this->assertTrue(Validator::validateData(0.0, Validation::required())->getResult());
        $this->assertTrue(Validator::validateData('string', Validation::required())->getResult());
        $this->assertTrue(Validator::validateData(['string'], Validation::required())->getResult());
        $this->assertTrue(Validator::validateData((object)['string'], Validation::required())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::required())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::required())->getResult());
    }

    public function testAllowedValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('null', Validation::allowed())->getResult());
        $this->assertTrue(Validator::validateData(null, Validation::allowed())->getResult());
    }

    public function testForbiddenValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::forbidden())->getResult());
        $this->assertFalse(Validator::validateData('null', Validation::forbidden())->getResult());
    }

    public function testAcceptedValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('ok', Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData('yeah', Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData('yep', Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData('yes', Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData('on', Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData(1, Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData('1', Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData(true, Validation::accepted())->getResult());
        $this->assertTrue(Validator::validateData('true', Validation::accepted())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::accepted())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::accepted())->getResult());
    }

    public function testDeclinedValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('not', Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData('nay', Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData('nope', Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData('no', Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData('off', Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData(0, Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData('0', Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::declined())->getResult());
        $this->assertTrue(Validator::validateData('false', Validation::declined())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::declined())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::declined())->getResult());
    }

    public function testBitValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(1, Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData(0, Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData('1', Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData('0', Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData(true, Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::bit())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::bit())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::bit())->getResult());
    }

    public function testBitIsOnValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(1, Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData('1', Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData(true, Validation::bit())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::bitIsOn())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::bitIsOn())->getResult());
    }

    public function testBitIsOffValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(0, Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData('0', Validation::bit())->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::bit())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::bitIsOff())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::bitIsOff())->getResult());
    }

    public function testYValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::equals(null))->getResult());
        $this->assertFalse(Validator::validateData('X', Validation::equals('Y'))->getResult());
    }

    public function testMatchesValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('abc', Validation::matches('/[a-z]+/'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::matches('/.+/'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::matches('/.+/'))->getResult());
    }

    public function testThreeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::in(null, false, 0))->getResult());
        $this->assertTrue(Validator::validateData(1, Validation::in(1, 2, 3))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::in(1, 2, 3))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::in(1, 'two', [3, 'three']))->getResult());
    }

    public function testCountValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(null, Validation::count(0))->getResult());
        $this->assertTrue(Validator::validateData(true, Validation::count(1))->getResult());
        $this->assertTrue(Validator::validateData(false, Validation::count(0))->getResult());
        $this->assertTrue(Validator::validateData(1, Validation::count(1))->getResult());
        $this->assertTrue(Validator::validateData(1.23, Validation::count(1.23))->getResult());
        $this->assertTrue(Validator::validateData('', Validation::count(0))->getResult());
        $this->assertTrue(Validator::validateData('abc', Validation::count(3))->getResult());
        $this->assertTrue(Validator::validateData([], Validation::count(0))->getResult());
        $this->assertTrue(Validator::validateData([1, 2, 3], Validation::count(3))->getResult());
        $this->assertTrue(Validator::validateData((object)['value'], Validation::count(1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::count(1))->getResult());
    }

    public function testMinValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('abc', Validation::min(1))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::min(1))->getResult());
        $this->assertFalse(Validator::validateData([], Validation::min(1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::min(1))->getResult());
    }

    public function testMaxValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([1, 2, 3], Validation::max(3))->getResult());
        $this->assertFalse(Validator::validateData([1, 2, 3, 4], Validation::max(3))->getResult());
        $this->assertFalse(Validator::validateData('abc123', Validation::max(3))->getResult());
    }

    public function testBetweenValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(2, Validation::between(1, 3))->getResult());
        $this->assertTrue(Validator::validateData([1, 2, 3], Validation::between(1, 3))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::between(1, 3))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::between(1, 3))->getResult());
    }

    public function testNumberIsPositiveValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(123, Validation::numberIsPositive())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsPositive())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsPositive())->getResult());
    }

    public function testNumberIsNegativeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(-123, Validation::numberIsNegative())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsNegative())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsNegative())->getResult());
    }

    public function testNumberIsEvenValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(0, Validation::numberIsEven())->getResult());
        $this->assertFalse(Validator::validateData(1, Validation::numberIsEven())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsEven())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsEven())->getResult());
    }

    public function testNumberIsOddValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(1, Validation::numberIsOdd())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::numberIsOdd())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsOdd())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsOdd())->getResult());
    }

    public function testNumberIsMultipleOfValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(9, Validation::numberIsMultipleOf(3))->getResult());
        $this->assertFalse(Validator::validateData(1, Validation::numberIsMultipleOf(3))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsMultipleOf(1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsMultipleOf(1))->getResult());
    }

    public function testNumberIsFiniteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(0, Validation::numberIsFinite())->getResult());
        $this->assertFalse(Validator::validateData(log(0), Validation::numberIsFinite())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsFinite())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsFinite())->getResult());
    }

    public function testNumberIsInfiniteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(log(0), Validation::numberIsInfinite())->getResult());
        $this->assertFalse(Validator::validateData(0, Validation::numberIsInfinite())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsInfinite())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsInfinite())->getResult());
    }

    public function testNumberIsNanValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(NAN, Validation::numberIsNan())->getResult());
        $this->assertFalse(Validator::validateData(123, Validation::numberIsNan())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::numberIsNan())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::numberIsNan())->getResult());
    }

    public function testStringCharsetValidationRule(): void
    {
        $this->assertFalse(Validator::validateData(null, Validation::stringCharset('ASCII'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::stringCharset('UNKNOWN'))->getResult());
        $this->assertTrue(Validator::validateData('', Validation::stringCharset('ASCII'))->getResult());
        $this->assertTrue(Validator::validateData('Straße', Validation::stringCharset('UTF-8'))->getResult());
    }

    public function testStringContainsValidationRule(): void
    {
        $this->assertFalse(Validator::validateData(null, Validation::stringContains(''))->getResult());
        $this->assertTrue(Validator::validateData('', Validation::stringContains(''))->getResult());
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringContains('Text'))->getResult());
    }

    public function testStringStartsWithValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringStartsWith('Test', true))->getResult());
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringStartsWith('test'))->getResult());
        $this->assertTrue(Validator::validateData('', Validation::stringStartsWith(''))->getResult());
        $this->assertFalse(Validator::validateData('Foo Bar', Validation::stringStartsWith('Baz'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::stringStartsWith())->getResult());
    }

    public function testStringEndsWithValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringEndsWith('Text', true))->getResult());
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringEndsWith('text'))->getResult());
        $this->assertTrue(Validator::validateData('', Validation::stringEndsWith())->getResult());
        $this->assertFalse(Validator::validateData('Foo Bar', Validation::stringEndsWith('Baz'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::stringEndsWith())->getResult());
    }

    public function testStringLengthValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringLength(9))->getResult());
        $this->assertTrue(Validator::validateData('', Validation::stringLength(0))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::stringLength(1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::stringLength(1))->getResult());
    }

    public function testStringWordsValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Test Text', Validation::stringWordsCount(2))->getResult());
        $this->assertFalse(Validator::validateData('Foo Bar Baz', Validation::stringWordsCount(1))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::stringWordsCount(1))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::stringWordsCount(1))->getResult());
    }

    public function testArrayHasKeyValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(['key' => 'value'], Validation::arrayHasKey('key'))->getResult());
        $this->assertFalse(Validator::validateData([], Validation::arrayHasKey('xxx'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arrayHasKey('xxx'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arrayHasKey('xxx'))->getResult());
    }

    public function testArrayHasValueValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(['key' => 'value'], Validation::arrayHasValue('value'))->getResult());
        $this->assertFalse(Validator::validateData([], Validation::arrayHasValue('xxx'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arrayHasValue('xxx'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arrayHasValue('xxx'))->getResult());
    }

    public function testArrayHasDistinctValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([['id' => 1], ['id' => 2]], Validation::arrayHasDistinct('id'))->getResult());
        $this->assertFalse(Validator::validateData([['id' => 1], ['id' => 1]], Validation::arrayHasDistinct('id'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arrayHasDistinct('xxx'))->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arrayHasDistinct('xxx'))->getResult());
    }

    public function testArrayIsAssociativeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(['key' => 'value'], Validation::arrayIsAssociative())->getResult());
        $this->assertFalse(Validator::validateData(['key', 'value'], Validation::arrayIsAssociative())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arrayIsAssociative())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arrayIsAssociative())->getResult());
    }

    public function testArrayIsSequentialValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(['key', 'value'], Validation::arrayIsSequential())->getResult());
        $this->assertFalse(Validator::validateData(['key' => 'value'], Validation::arrayIsSequential())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arrayIsSequential())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arrayIsSequential())->getResult());
    }

    public function testArrayIsUniqueValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([1, 2, 3], Validation::arrayIsUnique())->getResult());
        $this->assertFalse(Validator::validateData([1, 1, 1], Validation::arrayIsUnique())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arrayIsUnique())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arrayIsUnique())->getResult());
    }

    public function testArraySubsetValidationRule(): void
    {
        $this->assertTrue(Validator::validateData([1, 2, 3], Validation::arraySubset([1]))->getResult());
        $this->assertFalse(Validator::validateData([1, 2, 3], Validation::arraySubset([4]))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::arraySubset())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::arraySubset())->getResult());
    }

    public function testObjectHasPropertyValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(new \Exception('Test'), Validation::objectHasProperty('message'))->getResult());
        $this->assertFalse(Validator::validateData(new \Exception('Test'), Validation::objectHasProperty('xxx'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::objectHasProperty())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::objectHasProperty())->getResult());
    }

    public function testObjectHasMethodValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(new \Exception('Test'), Validation::objectHasMethod('getMessage'))->getResult());
        $this->assertFalse(Validator::validateData(new \Exception('Test'), Validation::objectHasMethod('xxx'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::objectHasMethod())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::objectHasMethod())->getResult());
    }

    public function testObjectIsStringableValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(new \Exception('Test'), Validation::objectIsStringable())->getResult());
        $this->assertFalse(Validator::validateData(new \stdClass(), Validation::objectIsStringable())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::objectIsStringable())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::objectIsStringable())->getResult());
    }

    public function testObjectIsInstanceOfValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(new \Exception('Test'), Validation::objectIsInstanceOf(\Throwable::class))->getResult());
        $this->assertFalse(Validator::validateData(new \Exception('Test'), Validation::objectIsInstanceOf(\Countable::class))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::objectIsInstanceOf())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::objectIsInstanceOf())->getResult());
    }

    public function testObjectIsSubclassOfValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(new \RuntimeException('Test'), Validation::objectIsSubclassOf(\Exception::class))->getResult());
        $this->assertFalse(Validator::validateData(new \Exception('Test'), Validation::objectIsSubclassOf(\Exception::class))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::objectIsSubclassOf())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::objectIsSubclassOf())->getResult());
    }

    public function testSerializedValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(serialize([1, 2, 3]), Validation::serialized())->getResult());
        $this->assertFalse(Validator::validateData('xxx', Validation::serialized())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::serialized())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::serialized())->getResult());
    }

    public function testJsonValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(json_encode([1, 2, 3]), Validation::json())->getResult());
        $this->assertFalse(Validator::validateData('xxx', Validation::json())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::json())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::json())->getResult());
    }

    public function testBase64ValidationRule(): void
    {
        $this->assertTrue(Validator::validateData(base64_encode('Test'), Validation::base64())->getResult());
        $this->assertFalse(Validator::validateData('xxx', Validation::base64())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::base64())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::base64())->getResult());
    }

    public function testXmlValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('<?xml version="1.0" standalone="yes"?><tag />', Validation::xml())->getResult());
        $this->assertFalse(Validator::validateData('xxx', Validation::xml())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::xml())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::xml())->getResult());
    }

    public function testRegexValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('/([a-z0-9])+/', Validation::regex())->getResult());
        $this->assertFalse(Validator::validateData('/([a-z0-9](+/', Validation::regex())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::regex())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::regex())->getResult());
    }

    public function testLocaleValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('ar', Validation::locale(strict: true))->getResult());
        $this->assertTrue(Validator::validateData('de_DE', Validation::locale(strict: true))->getResult());
        $this->assertTrue(Validator::validateData('nl_BE.UTF-8', Validation::locale())->getResult());
        $this->assertTrue(Validator::validateData('en-us', Validation::locale())->getResult());
        $this->assertFalse(Validator::validateData('en-us', Validation::locale(strict: true))->getResult());
        $this->assertFalse(Validator::validateData('xx', Validation::locale())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::locale())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::locale())->getResult());
    }

    public function testLanguageValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('ar', Validation::language())->getResult());
        $this->assertTrue(Validator::validateData('ara', Validation::language(long: true))->getResult());
        $this->assertTrue(Validator::validateData('de', Validation::language())->getResult());
        $this->assertTrue(Validator::validateData('deu', Validation::language(long: true))->getResult());
        $this->assertTrue(Validator::validateData('nl', Validation::language())->getResult());
        $this->assertTrue(Validator::validateData('nld', Validation::language(long: true))->getResult());
        $this->assertTrue(Validator::validateData('en', Validation::language())->getResult());
        $this->assertTrue(Validator::validateData('eng', Validation::language(long: true))->getResult());
        $this->assertFalse(Validator::validateData('xx', Validation::language(long: false))->getResult());
        $this->assertFalse(Validator::validateData('xxx', Validation::language(long: true))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::language())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::language())->getResult());
    }

    public function testCountryValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('IQ', Validation::country())->getResult());
        $this->assertTrue(Validator::validateData('IRQ', Validation::country(long: true))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::country())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::country())->getResult());
    }

    public function testTimezoneValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Europe/Berlin', Validation::timezone())->getResult());
        $this->assertTrue(Validator::validateData('europe/brussels', Validation::timezone(strict: false))->getResult());
        $this->assertTrue(Validator::validateData('Asia/Baghdad', Validation::timezone(strict: false))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::timezone())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::timezone())->getResult());
    }

    public function testDatetimeValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('now', Validation::datetime())->getResult());
        $this->assertTrue(Validator::validateData('2013-01-01 08:00', Validation::datetime())->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('now'), Validation::datetime())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetime())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetime())->getResult());
    }

    public function testDatetimeEqValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('yesterday', Validation::datetimeEq('yesterday'))->getResult());
        $this->assertTrue(Validator::validateData('01.01.2013', Validation::datetimeEq('01.01.2013'))->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('yesterday'), Validation::datetimeEq('yesterday'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeEq())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeEq())->getResult());
    }

    public function testDatetimeLtValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('yesterday', Validation::datetimeLt('tomorrow'))->getResult());
        $this->assertTrue(Validator::validateData('01.01.2013', Validation::datetimeLt('02.01.2013'))->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('yesterday'), Validation::datetimeLt('tomorrow'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeLt())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeLt())->getResult());
    }

    public function testDatetimeLteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('yesterday', Validation::datetimeLte('tomorrow'))->getResult());
        $this->assertTrue(Validator::validateData('01/01/2013', Validation::datetimeLte('01/01/2013'))->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('yesterday'), Validation::datetimeLte('tomorrow'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeLte())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeLte())->getResult());
    }

    public function testDatetimeGtValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('tomorrow', Validation::datetimeGt('yesterday'))->getResult());
        $this->assertTrue(Validator::validateData('tomorrow', Validation::datetimeGt('yesterday'))->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('tomorrow'), Validation::datetimeGt('yesterday'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeGt())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeGt())->getResult());
    }

    public function testDatetimeGteValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('tomorrow', Validation::datetimeGte('yesterday'))->getResult());
        $this->assertTrue(Validator::validateData('01.01.2013', Validation::datetimeGte('01.01.2012'))->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('tomorrow'), Validation::datetimeGte('yesterday'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeGte())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeGte())->getResult());
    }

    public function testDatetimeBirthdayValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('today', Validation::datetimeBirthday())->getResult());
        $this->assertTrue(Validator::validateData(date('Y-m-d', strtotime('today')), Validation::datetimeBirthday())->getResult());
        $this->assertTrue(Validator::validateData(new \DateTime('today'), Validation::datetimeBirthday())->getResult());
        $this->assertFalse(Validator::validateData(new \DateTime('yesterday'), Validation::datetimeBirthday())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeBirthday())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeBirthday())->getResult());
    }

    public function testDatetimeFormatValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('2013-01-01', Validation::datetimeFormat('Y-m-d'))->getResult());
        $this->assertTrue(Validator::validateData('2013-01-01', Validation::datetimeFormat('Y-m-d'))->getResult());
        $this->assertTrue(Validator::validateData('Saturday', Validation::datetimeFormat('l'))->getResult());
        $this->assertFalse(Validator::validateData('xyz', Validation::datetimeFormat('Y-m-d'))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeFormat())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeFormat())->getResult());
    }

    public function testDatetimeFormatGlobalValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('2013-01-01T00:00:00.000+0000', Validation::datetimeFormatGlobal())->getResult());
        $this->assertFalse(Validator::validateData('2013-01-01T00:00:00.000', Validation::datetimeFormatGlobal())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeFormatGlobal())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeFormatGlobal())->getResult());
    }

    public function testDatetimeFormatLocalValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('2013-01-01T00:00:00.000', Validation::datetimeFormatLocal())->getResult());
        $this->assertFalse(Validator::validateData('2013-01-01T00:00:00.000+0000', Validation::datetimeFormatLocal())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datetimeFormatLocal())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datetimeFormatLocal())->getResult());
    }

    public function testDatestampValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('01/01/2013', Validation::datestamp())->getResult());
        $this->assertTrue(Validator::validateData('12-31-2013', Validation::datestamp())->getResult());
        $this->assertTrue(Validator::validateData('31.12.2013', Validation::datestamp())->getResult());
        $this->assertFalse(Validator::validateData('31.31.2013', Validation::datestamp())->getResult());
        $this->assertFalse(Validator::validateData('12.12/2013', Validation::datestamp())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datestamp())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datestamp())->getResult());
    }

    public function testDatestampYmdValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('2013-01-01', Validation::datestampYmd())->getResult());
        $this->assertFalse(Validator::validateData('2013-13-32', Validation::datestampYmd())->getResult());
        $this->assertFalse(Validator::validateData('01-01-2013', Validation::datestampYmd())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datestampYmd())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datestampYmd())->getResult());
    }

    public function testDatestampDmyValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('31-12-2013', Validation::datestampDmy())->getResult());
        $this->assertFalse(Validator::validateData('12-31-2013', Validation::datestampDmy())->getResult());
        $this->assertFalse(Validator::validateData('32-13-2013', Validation::datestampDmy())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datestampDmy())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datestampDmy())->getResult());
    }

    public function testDatestampMdyValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('12-31-2013', Validation::datestampMdy())->getResult());
        $this->assertFalse(Validator::validateData('31-12-2013', Validation::datestampMdy())->getResult());
        $this->assertFalse(Validator::validateData('13-32-2013', Validation::datestampMdy())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::datestampMdy())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::datestampMdy())->getResult());
    }

    public function testTimestampValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('00:00:00', Validation::timestamp())->getResult());
        $this->assertTrue(Validator::validateData('08:30:45', Validation::timestamp())->getResult());
        $this->assertTrue(Validator::validateData('12:00:00', Validation::timestamp())->getResult());
        $this->assertTrue(Validator::validateData('13:00:00', Validation::timestamp())->getResult());
        $this->assertFalse(Validator::validateData('24:60:60', Validation::timestamp())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::timestamp())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::timestamp())->getResult());
    }

    public function testTimestamp12ValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('00:00:00', Validation::timestamp12())->getResult());
        $this->assertTrue(Validator::validateData('08:30:45 AM', Validation::timestamp12())->getResult());
        $this->assertTrue(Validator::validateData('12:00:00', Validation::timestamp12())->getResult());
        $this->assertFalse(Validator::validateData('13:00:00', Validation::timestamp12())->getResult());
        $this->assertFalse(Validator::validateData('12:60:60', Validation::timestamp12())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::timestamp12())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::timestamp12())->getResult());
    }

    public function testTimestampHmsValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('06:00:00', Validation::timestampHms())->getResult());
        $this->assertFalse(Validator::validateData('06:00', Validation::timestampHms())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::timestampHms())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::timestampHms())->getResult());
    }

    public function testTimestampHmValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('12:00', Validation::timestampHm())->getResult());
        $this->assertFalse(Validator::validateData('12:00:00', Validation::timestampHm())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::timestampHm())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::timestampHm())->getResult());
    }

    public function testTimestampMsValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('30:00', Validation::timestampMs())->getResult());
        $this->assertFalse(Validator::validateData('00:30:00', Validation::timestampMs())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::timestampMs())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::timestampMs())->getResult());
    }

    public function testCalenderMonthValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Monday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Mon', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Tuesday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Tue', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Wednesday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Wed', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Thursday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Thu', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Friday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Fri', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Saturday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Sat', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Sunday', Validation::calenderDay())->getResult());
        $this->assertTrue(Validator::validateData('Sun', Validation::calenderDay())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::calenderDay())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::calenderDay())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::calenderDay())->getResult());

        // months
        $this->assertTrue(Validator::validateData('January', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Jan', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('February', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Feb', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('March', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Mar', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('April', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Apr', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('May', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('June', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Jun', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('July', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Jul', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('August', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Aug', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('September', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Sep', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('October', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Oct', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('November', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Nov', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('December', Validation::calenderMonth())->getResult());
        $this->assertTrue(Validator::validateData('Dec', Validation::calenderMonth())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::calenderMonth())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::calenderMonth())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::calenderMonth())->getResult());
    }

    public function testColorValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('#ffffff', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('#fff', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('#ffffff5f', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('#fff5', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('rgb(255,255,255)', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('rgba(0,0,0,0.15)', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('rgb(255 255 255 / 50%)', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('hsl(0, 100%, 100%)', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('hsla(0, 0%, 0%, 0.15)', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('hsl(120deg 100% 100% / 50%)', Validation::color())->getResult());
        $this->assertTrue(Validator::validateData('dodgerblue', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('#xxxxxx', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('#xxx', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('#xxxxxx5x', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('#xxx5', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('rgb(256,256,256)', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('rgba(0,0,0,-0.15)', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('rgb(256 256 256 / 200%)', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('hsl(3600, 200%, 200%)', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('hsla(3600, 0%, 0%, -0.15)', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('hsl(3600deg 100% 100% / 500%)', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('aVeryLongColorNameThatDoesNotExist', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::color())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::color())->getResult());
    }

    public function testColorHexValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('#ffffff', Validation::colorHex())->getResult());
        $this->assertFalse(Validator::validateData('#xfffff', Validation::colorHex())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHex())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHex())->getResult());
    }

    public function testColorHexShortValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('#fff', Validation::colorHexShort())->getResult());
        $this->assertFalse(Validator::validateData('#xff', Validation::colorHexShort())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHexShort())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHexShort())->getResult());
    }

    public function testColorHexLongValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('#ffffff', Validation::colorHexLong())->getResult());
        $this->assertFalse(Validator::validateData('#xfffff', Validation::colorHexLong())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHexLong())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHexLong())->getResult());
    }

    public function testColorHexAlphaValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('#ffffff5f', Validation::colorHexAlpha())->getResult());
        $this->assertTrue(Validator::validateData('#fff5', Validation::colorHexAlpha())->getResult());
        $this->assertFalse(Validator::validateData('#xfffff5f', Validation::colorHexAlpha())->getResult());
        $this->assertFalse(Validator::validateData('#xff5', Validation::colorHexAlpha())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHexAlpha())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHexAlpha())->getResult());
    }

    public function testColorRgbValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('rgb(255,255,255)', Validation::colorRgb())->getResult());
        $this->assertFalse(Validator::validateData('rgb (255,255,255)', Validation::colorRgb())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorRgb())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorRgb())->getResult());
    }

    public function testColorRgbaValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('rgba(0,0,0,0.15)', Validation::colorRgba())->getResult());
        $this->assertFalse(Validator::validateData('rgba (0,0,0,0.15)', Validation::colorRgba())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorRgba())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorRgba())->getResult());
    }

    public function testColorRgbNewValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('rgb(255 255 255 / 50%)', Validation::colorRgbNew())->getResult());
        $this->assertFalse(Validator::validateData('rgb (255 255 255 / 50%)', Validation::colorRgbNew())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorRgbNew())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorRgbNew())->getResult());
    }

    public function testColorHslValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('hsl(0, 100%, 100%)', Validation::colorHsl())->getResult());
        $this->assertFalse(Validator::validateData('hsl (0, 100%, 100%)', Validation::colorHsl())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHsl())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHsl())->getResult());
    }

    public function testColorHslaValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('hsla(0, 0%, 0%, 0.15)', Validation::colorHsla())->getResult());
        $this->assertFalse(Validator::validateData('hsla (0, 0%, 0%, 0.15)', Validation::colorHsla())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHsla())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHsla())->getResult());
    }

    public function testColorHslNewValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('hsl(120deg 100% 100% / 50%)', Validation::colorHslNew())->getResult());
        $this->assertFalse(Validator::validateData('hsl (120deg 100% 100% / 50%)', Validation::colorHslNew())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorHslNew())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorHslNew())->getResult());
    }

    public function testColorKeywordValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('tomato', Validation::colorKeyword())->getResult());
        $this->assertFalse(Validator::validateData('xxx', Validation::colorKeyword())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::colorKeyword())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::colorKeyword())->getResult());
    }

    public function testUsernameValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('MarwanAlsoltany', Validation::username())->getResult());
        $this->assertTrue(Validator::validateData('MarwanAlsoltany.2022', Validation::username())->getResult());
        $this->assertTrue(Validator::validateData('MarwanAlsoltany-2022', Validation::username())->getResult());
        $this->assertTrue(Validator::validateData('MarwanAlsoltany_2022', Validation::username())->getResult());
        $this->assertFalse(Validator::validateData('Marwan Al-Soltany', Validation::username())->getResult());
        $this->assertFalse(Validator::validateData('2022Marwan', Validation::username())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::username())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::username())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::username())->getResult());
    }

    public function testPasswordValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Password@Secret.123', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData('Password@Secret.ABC', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData('Password@Secret', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData('Password@', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData('Password', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData('password', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::password())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::password())->getResult());
    }

    public function testUuidValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('123e4567-e89b-02d3-a456-426614174000', Validation::uuid())->getResult());
        $this->assertTrue(Validator::validateData('123e4567-e89b-12d3-a456-426614174000', Validation::uuid(1))->getResult());
        $this->assertTrue(Validator::validateData('123e4567-e89b-22d3-a456-426614174000', Validation::uuid(2))->getResult());
        $this->assertTrue(Validator::validateData('123e4567-e89b-32d3-a456-426614174000', Validation::uuid(3))->getResult());
        $this->assertTrue(Validator::validateData('123e4567-e89b-42d3-a456-426614174000', Validation::uuid(4))->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::uuid())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::uuid())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::uuid())->getResult());
    }

    public function testAsciiValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('mighty@test', Validation::ascii())->getResult());
        $this->assertFalse(Validator::validateData('äåéþüúíóöáßðøæñµ', Validation::ascii())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::ascii())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ascii())->getResult());
    }

    public function testSlugValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('hello-world', Validation::slug())->getResult());
        $this->assertFalse(Validator::validateData('Hello-World', Validation::slug())->getResult());
        $this->assertFalse(Validator::validateData('hello world', Validation::slug())->getResult());
        $this->assertFalse(Validator::validateData('haupt-straße', Validation::slug())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::slug())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::slug())->getResult());
    }

    public function testMetaValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('@#$', Validation::meta())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::meta())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::meta())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::meta())->getResult());
    }

    public function testTextValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('OK! This is a sample text.', Validation::text())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::text())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::text())->getResult());
    }

    public function testWordsValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Hello World', Validation::words())->getResult());
        $this->assertTrue(Validator::validateData('lorem ipsum dollar', Validation::words())->getResult());
        $this->assertFalse(Validator::validateData('not-good', Validation::words())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::words())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::words())->getResult());
    }

    public function testSpacelessValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('HelloWorld', Validation::spaceless())->getResult());
        $this->assertFalse(Validator::validateData('Hello World', Validation::spaceless())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::spaceless())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::spaceless())->getResult());
    }

    public function testEmojiValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('👍', Validation::emoji())->getResult());
        $this->assertTrue(Validator::validateData('🎈', Validation::emoji())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::emoji())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::emoji())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::emoji())->getResult());
    }

    public function testRomanValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('I', Validation::roman())->getResult());
        $this->assertTrue(Validator::validateData('II', Validation::roman())->getResult());
        $this->assertTrue(Validator::validateData('III', Validation::roman())->getResult());
        $this->assertTrue(Validator::validateData('IV', Validation::roman())->getResult());
        $this->assertTrue(Validator::validateData('V', Validation::roman())->getResult());
        $this->assertTrue(Validator::validateData('VI', Validation::roman())->getResult());
        $this->assertTrue(Validator::validateData('MMXV', Validation::roman())->getResult());
        $this->assertFalse(Validator::validateData('ABC', Validation::roman())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::roman())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::roman())->getResult());
    }

    public function testPhoneValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('+49 30 901820', Validation::phone())->getResult());
        $this->assertTrue(Validator::validateData('+1 (555) 555-1234', Validation::phone())->getResult());
        $this->assertFalse(Validator::validateData('123', Validation::phone())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::phone())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::phone())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::phone())->getResult());
    }

    public function testGeolocationValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('13.404954, 52.520008', Validation::geolocation())->getResult());
        $this->assertFalse(Validator::validateData('99.000000, 99.000000', Validation::geolocation())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::geolocation())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::geolocation())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::geolocation())->getResult());
    }

    public function testVersionValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('1.0.0', Validation::version())->getResult());
        $this->assertTrue(Validator::validateData('v1.1.0', Validation::version())->getResult());
        $this->assertTrue(Validator::validateData('v0.0.1-beta', Validation::version())->getResult());
        $this->assertTrue(Validator::validateData('v0.0.1-beta.1', Validation::version())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::version())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::version())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::version())->getResult());
    }

    public function testAmountValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('123', Validation::amount())->getResult());
        $this->assertTrue(Validator::validateData('2500', Validation::amount())->getResult());
        $this->assertTrue(Validator::validateData('-25,000.00', Validation::amount())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::amount())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::amount())->getResult());
    }

    public function testAmountDollarValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('$1,234.56', Validation::amountDollar())->getResult());
        $this->assertTrue(Validator::validateData('US$ 123', Validation::amountDollar())->getResult());
        $this->assertTrue(Validator::validateData('$ 99.99', Validation::amountDollar())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::amountDollar())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::amountDollar())->getResult());
    }

    public function testAmountEuroValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('1.234,56 €', Validation::amountEuro())->getResult());
        $this->assertTrue(Validator::validateData('123 EUR', Validation::amountEuro())->getResult());
        $this->assertTrue(Validator::validateData('99,99€', Validation::amountEuro())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::amountEuro())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::amountEuro())->getResult());
    }

    public function testSsnValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('778-62-8144', Validation::ssn())->getResult());
        $this->assertTrue(Validator::validateData('502 64 2680', Validation::ssn())->getResult());
        $this->assertTrue(Validator::validateData('284081566', Validation::ssn())->getResult());
        $this->assertFalse(Validator::validateData('0000', Validation::ssn())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::ssn())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::ssn())->getResult());
    }

    public function testNinoValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('AR-00-54-04-A', Validation::nino())->getResult());
        $this->assertTrue(Validator::validateData('NA 19 90 45 C', Validation::nino())->getResult());
        $this->assertTrue(Validator::validateData('GP222767B', Validation::nino())->getResult());
        $this->assertFalse(Validator::validateData('0000', Validation::nino())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::nino())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::nino())->getResult());
    }

    public function testSinValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('278-350-574', Validation::sin())->getResult());
        $this->assertTrue(Validator::validateData('073 784 639', Validation::sin())->getResult());
        $this->assertTrue(Validator::validateData('289112146', Validation::sin())->getResult());
        $this->assertFalse(Validator::validateData('0000', Validation::sin())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::sin())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::sin())->getResult());
    }

    public function testVinValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('5XYKT3A69DG353356', Validation::vin())->getResult());
        $this->assertTrue(Validator::validateData('JF2SHADC3DG417185', Validation::vin())->getResult());
        $this->assertTrue(Validator::validateData('2FMDK4KC4CBA27842', Validation::vin())->getResult());
        $this->assertFalse(Validator::validateData('ABC111EFG222XY00Z', Validation::vin())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::vin())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::vin())->getResult());
    }

    public function testIssnValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('0959-4752', Validation::issn())->getResult());
        $this->assertTrue(Validator::validateData('ISSN: 0028-0836', Validation::issn())->getResult());
        $this->assertTrue(Validator::validateData('eISSN: 1476-4687', Validation::issn())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::issn())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::issn())->getResult());
    }

    public function testIsinValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('NA-000K0VF05-4', Validation::isin())->getResult());
        $this->assertTrue(Validator::validateData('PL 854806711 4', Validation::isin())->getResult());
        $this->assertTrue(Validator::validateData('BA4805680417', Validation::isin())->getResult());
        $this->assertTrue(Validator::validateData('ISIN:NA8353031747', Validation::isin())->getResult());
        $this->assertTrue(Validator::validateData('ISIN: BA4805680417', Validation::isin())->getResult());
        $this->assertTrue(Validator::validateData('ISIN GN3765327357', Validation::isin())->getResult());
        $this->assertFalse(Validator::validateData('0000', Validation::isin())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::isin())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::isin())->getResult());
    }

    public function testIsbnValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('0-4456-5880-0', Validation::isbn())->getResult());
        $this->assertTrue(Validator::validateData('978-3-1614-8410-0', Validation::isbn())->getResult());
        $this->assertTrue(Validator::validateData('0 9309 6091 2', Validation::isbn(10))->getResult());
        $this->assertTrue(Validator::validateData('0-1216-1117-5', Validation::isbn(10))->getResult());
        $this->assertTrue(Validator::validateData('012521961X', Validation::isbn(10))->getResult());
        $this->assertTrue(Validator::validateData('ISBN: 0-8847-6239-4', Validation::isbn(10))->getResult());
        $this->assertTrue(Validator::validateData('978-6-1745-1558-8', Validation::isbn(13))->getResult());
        $this->assertTrue(Validator::validateData('978 3 6276 2012 7', Validation::isbn(13))->getResult());
        $this->assertTrue(Validator::validateData('9784133978016', Validation::isbn(13))->getResult());
        $this->assertTrue(Validator::validateData('ISBN: 978-3-6902-3313-2', Validation::isbn(13))->getResult());
        $this->assertFalse(Validator::validateData('23156465152', Validation::isbn())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::isbn())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::isbn())->getResult());
    }

    public function testImeiValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('35-209900-176148-1', Validation::imei())->getResult());
        $this->assertTrue(Validator::validateData('490154203237518', Validation::imei())->getResult());
        $this->assertTrue(Validator::validateData('IMEI: 10378380802522', Validation::imei())->getResult());
        $this->assertFalse(Validator::validateData('1854215432154', Validation::imei())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::imei())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imei())->getResult());
    }

    public function testImeiSvValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('35-209900-176148-23', Validation::imeiSv())->getResult());
        $this->assertTrue(Validator::validateData('9810021447882210', Validation::imeiSv())->getResult());
        $this->assertTrue(Validator::validateData('IMEI-SV: 4523319123155971', Validation::imeiSv())->getResult());
        $this->assertFalse(Validator::validateData('44851479665443', Validation::imeiSv())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::imeiSv())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::imeiSv())->getResult());
    }

    public function testMeidValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('A0-000004-9259B1-6', Validation::meid())->getResult());
        $this->assertTrue(Validator::validateData('AF 012345 0ABCDE', Validation::meid())->getResult());
        $this->assertTrue(Validator::validateData('MEID: 35502304084522', Validation::meid())->getResult());
        $this->assertFalse(Validator::validateData('564154532155', Validation::meid())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::meid())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::meid())->getResult());
    }

    public function testEsnValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('89aaff99', Validation::esn())->getResult());
        $this->assertTrue(Validator::validateData('1a5b-9c7f', Validation::esn())->getResult());
        $this->assertTrue(Validator::validateData('ESN: 415453f1', Validation::esn())->getResult());
        $this->assertFalse(Validator::validateData('c4f8d52', Validation::esn())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::esn())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::esn())->getResult());
    }

    public function testCurrencyValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('IQD', Validation::currency())->getResult());
        $this->assertTrue(Validator::validateData('USD', Validation::currency())->getResult());
        $this->assertTrue(Validator::validateData('EUR', Validation::currency())->getResult());
        $this->assertTrue(Validator::validateData('368', Validation::currency(numeric: true))->getResult());
        $this->assertTrue(Validator::validateData('840', Validation::currency(numeric: true))->getResult());
        $this->assertTrue(Validator::validateData('978', Validation::currency(numeric: true))->getResult());
        $this->assertFalse(Validator::validateData('XYZ', Validation::currency())->getResult());
        $this->assertFalse(Validator::validateData('000', Validation::currency(numeric: true))->getResult());
        $this->assertFalse(Validator::validateData('', Validation::currency())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::currency())->getResult());
    }

    public function testCurrencyNameValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('Dinar', Validation::currencyName())->getResult());
        $this->assertTrue(Validator::validateData('Dollar', Validation::currencyName())->getResult());
        $this->assertTrue(Validator::validateData('Euro', Validation::currencyName())->getResult());
        $this->assertFalse(Validator::validateData('XXX', Validation::currencyName())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::currencyName())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::currencyName())->getResult());
    }

    public function testCreditcardValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('5114229116749752', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('4916615075747022', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('4394898386944', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('347359335430191', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('6558604123379119', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('36304841450343', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('3563665812658394', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('6253229615495526', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('6761390246099155', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('6304416423381175', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('6380806088499709', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('188569545938560', Validation::creditcard())->getResult());
        $this->assertTrue(Validator::validateData('2204079059374548', Validation::creditcard())->getResult());
        $this->assertFalse(Validator::validateData('00000000', Validation::creditcard())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcard())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcard())->getResult());
    }

    public function testCreditcardVisaValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('4575414549840874', Validation::creditcardVisa())->getResult());
        $this->assertTrue(Validator::validateData('4823-9747-3210-2408', Validation::creditcardVisa())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardVisa())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardVisa())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardVisa())->getResult());
    }

    public function testCreditcardMastercardValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('5372477276512000', Validation::creditcardMastercard())->getResult());
        $this->assertTrue(Validator::validateData('5494-4955-6305-0669', Validation::creditcardMastercard())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardMastercard())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardMastercard())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardMastercard())->getResult());
    }

    public function testCreditcardDiscoverValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('6507907701261282', Validation::creditcardDiscover())->getResult());
        $this->assertTrue(Validator::validateData('6011-5178-4153-3711', Validation::creditcardDiscover())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardDiscover())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardDiscover())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardDiscover())->getResult());
    }

    public function testCreditcardAmericanExpressValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('371144728175034', Validation::creditcardAmericanExpress())->getResult());
        $this->assertTrue(Validator::validateData('3740-799035-56561', Validation::creditcardAmericanExpress())->getResult());
        $this->assertTrue(Validator::validateData('3492-8588-1201-542', Validation::creditcardAmericanExpress())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardAmericanExpress())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardAmericanExpress())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardAmericanExpress())->getResult());
    }

    public function testCreditcardDinersClubValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('214959887328110', Validation::creditcardDinersClub())->getResult());
        $this->assertTrue(Validator::validateData('3059-4872-5872-47', Validation::creditcardDinersClub())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-00', Validation::creditcardDinersClub())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardDinersClub())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardDinersClub())->getResult());
    }

    public function testCreditcardJcbValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('3533105151336648', Validation::creditcardJcb())->getResult());
        $this->assertTrue(Validator::validateData('3528-9050-3251-5469', Validation::creditcardJcb())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardJcb())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardJcb())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardJcb())->getResult());
    }

    public function testCreditcardMaestroValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('6767120544308519', Validation::creditcardMaestro())->getResult());
        $this->assertTrue(Validator::validateData('6766-0285-8948-0062', Validation::creditcardMaestro())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardMaestro())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardMaestro())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardMaestro())->getResult());
    }

    public function testCreditcardChinaUnionPayValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('6231937081946122', Validation::creditcardChinaUnionPay())->getResult());
        $this->assertTrue(Validator::validateData('6288-2459-0608-9199', Validation::creditcardChinaUnionPay())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardChinaUnionPay())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardChinaUnionPay())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardChinaUnionPay())->getResult());
    }

    public function testCreditcardInstaPaymentValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('6388245252770920', Validation::creditcardInstaPayment())->getResult());
        $this->assertTrue(Validator::validateData('6391-6815-7647-3582', Validation::creditcardInstaPayment())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardInstaPayment())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardInstaPayment())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardInstaPayment())->getResult());
    }

    public function testCreditcardLaserValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('6709565865172277', Validation::creditcardLaser())->getResult());
        $this->assertTrue(Validator::validateData('6771-2594-8320-5015', Validation::creditcardLaser())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardLaser())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardLaser())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardLaser())->getResult());
    }

    public function testCreditcardUatpValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('151161275949277', Validation::creditcardUatp())->getResult());
        $this->assertTrue(Validator::validateData('1896-3658-1084-939', Validation::creditcardUatp())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-000', Validation::creditcardUatp())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardUatp())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardUatp())->getResult());
    }

    public function testCreditcardMirValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('2203692499334150', Validation::creditcardMir())->getResult());
        $this->assertTrue(Validator::validateData('2201-2451-8221-5452', Validation::creditcardMir())->getResult());
        $this->assertFalse(Validator::validateData('0000-0000-0000-0000', Validation::creditcardMir())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::creditcardMir())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::creditcardMir())->getResult());
    }

    public function testCvvValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('247', Validation::cvv())->getResult());
        $this->assertTrue(Validator::validateData('777', Validation::cvv())->getResult());
        $this->assertTrue(Validator::validateData('1234', Validation::cvv())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::cvv())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::cvv())->getResult());
    }

    public function testBicValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('NOLADE21BER', Validation::bic())->getResult());
        $this->assertTrue(Validator::validateData('NOLADE21GOE', Validation::bic())->getResult());
        $this->assertTrue(Validator::validateData('NOLADE21DUD', Validation::bic())->getResult());
        $this->assertFalse(Validator::validateData('XYZ', Validation::bic())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::bic())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::bic())->getResult());
    }

    public function testIbanValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('BE78735599741486', Validation::iban())->getResult());
        $this->assertTrue(Validator::validateData('DE42500105176122528568', Validation::iban())->getResult());
        $this->assertTrue(Validator::validateData('GB88BARC20039587495124', Validation::iban())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::iban())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::iban())->getResult());
    }

    public function testLuhnValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('4417 1234 5678 9113', Validation::luhn())->getResult());
        $this->assertTrue(Validator::validateData('5577-4248-0767-3722', Validation::luhn())->getResult());
        $this->assertTrue(Validator::validateData('378066053203407', Validation::luhn())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::luhn())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::luhn())->getResult());
    }

    public function testPhpKeywordValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('return', Validation::phpKeyword())->getResult());
        $this->assertTrue(Validator::validateData('for', Validation::phpKeyword())->getResult());
        $this->assertTrue(Validator::validateData('if', Validation::phpKeyword())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::phpKeyword())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::phpKeyword())->getResult());
    }

    public function testPhpReservedValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('bool', Validation::phpReserved())->getResult());
        $this->assertTrue(Validator::validateData('int', Validation::phpReserved())->getResult());
        $this->assertTrue(Validator::validateData('string', Validation::phpReserved())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::phpReserved())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::phpReserved())->getResult());
    }

    public function testPhpReservedExtraValidationRule(): void
    {
        $this->assertTrue(Validator::validateData('readonly', Validation::phpReservedExtra())->getResult());
        $this->assertTrue(Validator::validateData('enum', Validation::phpReservedExtra())->getResult());
        $this->assertFalse(Validator::validateData('', Validation::phpReservedExtra())->getResult());
        $this->assertFalse(Validator::validateData(null, Validation::phpReservedExtra())->getResult());
    }


    private function getExecutableFile(): string
    {
        $executable = trim(exec(sprintf('%s php', PHP_OS === 'WINNT' ? 'where' : 'which')) ?: '');

        if (empty($executable)) {
            $executable = PHP_OS === 'WINNT' ? 'C:\Windows\System32\where.exe' : '/usr/bin/which';
        }

        return $executable;
    }

    private function createTestLink(): string
    {
        $link = __DIR__ . '/test-link.php';

        symlink(__FILE__, $link);

        return $link;
    }

    private function destroyTestLink(?string $path = null): bool
    {
        $link = __DIR__ . '/test-link.php';

        return unlink($path);
    }

    private function createTestImage(): string
    {
        $path = __DIR__ . '/test-image.jpg';

        if (file_exists($path)) {
            unlink($path);
        }

        $image = imagecreate(16, 16);
        $color = imagecolorallocate($image, 0, 0, 0);
        $color = imagecolorallocate($image, 255, 255, 255);
        imagestring($image, 1, 5, 5, 'T', $color);
        imagejpeg($image, $path);
        imagedestroy($image);

        return $path;
    }

    private function destroyTestImage(?string $path = null): bool
    {
        $path ??= __DIR__ . '/test-image.jpg';

        return unlink($path);
    }
}

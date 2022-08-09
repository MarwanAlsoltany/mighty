<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests\Support;

use MAKS\Mighty\Support\Utility;
use MAKS\Mighty\TestCase;

class UtilityTest extends TestCase
{
    public function testUtilityGetArrayValueMethod(): void
    {
        $array = $this->getTestArray();

        $this->assertEquals('none', Utility::getArrayValue([], '0', 'none'));
        $this->assertEquals('none', Utility::getArrayValue(['none'], '0'));
        $this->assertEquals('test', Utility::getArrayValue($array, 'item1'));
        $this->assertEquals(123, Utility::getArrayValue($array, 'item2'));
        $this->assertEquals(true, Utility::getArrayValue($array, 'item3.sub1'));
        $this->assertEquals(false, Utility::getArrayValue($array, 'item3.sub2'));
        $this->assertEquals(null, Utility::getArrayValue($array, 'item3.sub3.nested1'));
        $this->assertEquals(null, Utility::getArrayValue($array, 'item4'));
        $this->assertIsArray(Utility::getArrayValue($array, 'item4.sub1'));
        $this->assertEquals(true, Utility::getArrayValue($array, 'item4.sub1.nested1'));
        $this->assertEquals(false, Utility::getArrayValue($array, 'item4.sub1.nested2'));
        $this->assertEquals('none', Utility::getArrayValue($array, 'item5.sub1.nested1', 'none'));
        $this->assertEquals('none', Utility::getArrayValue($array, 'item6', 'none'));
    }

    public function testExpandArrayWildcardsMethod(): void
    {
        $array = $this->getTestArray();

        $actual = Utility::expandArrayWildcards(['*' => '$'], $array);
        $expected = [
            'item1' => '$',
            'item2' => '$',
            'item3' => '$',
            'item4.sub1' => '$',
            'item5' => '$',
        ];

        $this->assertEquals($expected, $actual);

        $actual = Utility::expandArrayWildcards([
            'item0'     => '$',
            'item1.*'   => '$',
            'item2.*'   => '$',
            'item3.*' => '$',
            'item3.*.*' => '$',
            'item4.*'   => '$',
            'item5.*'   => '$',
        ], $array);
        $expected = [
            'item0' => '$',
            'item1' => '$',
            'item2' => '$',
            'item3.sub1' => '$',
            'item3.sub2' => '$',
            'item3.sub3' => '$',
            'item3.sub3.nested1' => '$',
            'item4' => '$',
            'item5' => '$',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCastToArrayMethod(): void
    {
        $this->assertEquals([], Utility::castToArray(null));
        $this->assertEquals([false], Utility::castToArray(false));
        $this->assertEquals([true], Utility::castToArray(true));
        $this->assertEquals([0], Utility::castToArray(0));
        $this->assertEquals([''], Utility::castToArray(''));

        $object = new class() {
            private $item1 = null;
            private $item2 = true;
            private $item3 = false;
            private $item4 = 123;
            private $item5 = 'test';
            protected $item6 = [1, 'two', 'three' => 3];
            public $item7;

            public function __construct()
            {
                $self = clone $this;
                $self->item7 = (object)[];

                $this->item7 = new \stdClass();
                $this->item7->itemA = 'test';
                $this->item7->itemB = $self;
            }
        };

        $actual   = Utility::castToArray($object);
        $expected = [
            'item1' => null,
            'item2' => true,
            'item3' => false,
            'item4' => 123,
            'item5' => 'test',
            'item6' => [1, 'two', 'three' => 3],
            'item7' => [
                'itemA' => 'test',
                'itemB' => [
                    'item1' => null,
                    'item2' => true,
                    'item3' => false,
                    'item4' => 123,
                    'item5' => 'test',
                    'item6' => [1, 'two', 'three' => 3],
                    'item7' => [],
                ],
            ],
        ];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testInjectInArrayMethod(): void
    {
        $data = $this->getInjectionTestData();

        $this->assertEmpty(Utility::injectInArray([], $data));
        $this->assertEquals(['value'], Utility::injectInArray(['@array.item'], $data));
        $this->assertNull(Utility::injectInArray(['null'], $data)[0]);
        $this->assertTrue(Utility::injectInArray(['true'], $data)[0]);
        $this->assertFalse(Utility::injectInArray(['false'], $data)[0]);
        $this->assertIsString(Utility::injectInArray(['string'], $data)[0]);
    }

    public function testInjectInStringMethod(): void
    {
        $data = $this->getInjectionTestData();

        $this->assertIsString(Utility::injectInString('', $data));
        $this->assertEmpty(Utility::injectInString('', []));
        $this->assertEquals('This stays as is!', Utility::injectInString('This stays as is!', $data));
        $this->assertEquals('Array item equals "value".', Utility::injectInString('Array item equals ${@array.item}.', $data));
        $this->assertEquals('This is null.', Utility::injectInString('This is ${null}.', $data));
        $this->assertEquals('This is true.', Utility::injectInString('This is ${true}.', $data));
        $this->assertEquals('This is false.', Utility::injectInString('This is ${false}.', $data));
        $this->assertEquals('This is "string".', Utility::injectInString('This is ${string}.', $data));
        $this->assertEquals('This is an empty array ([]).', Utility::injectInString('This is an empty array (${array}).', $data));
        $this->assertEquals('The array is ({"item":"value"}).', Utility::injectInString('The array is (${@array}).', $data));
        $this->assertEquals('This is "UNKNOWN".', Utility::injectInString('This is ${path.to.somewhere:UNKNOWN}.', $data));
    }

    public function testMiscInterpolateMethod()
    {
        $text1 = Utility::interpolate('This is {text} ...', $context = ['text' => 'an interpolated text']);
        $text2 = Utility::interpolate('This is <text> with a different placeholder ...', $context, '<>');
        $text3 = Utility::interpolate('This is text with a different placeholder ...', $context, '');
        $text4 = Utility::interpolate('This is [text] with a different placeholder ...', $context, '[|]');
        $text5 = Utility::interpolate('This is a value of an object {object} (JSON)', ['object' => (object)['value' => 'object']]);
        $text6 = Utility::interpolate('This is a value of a {stringable}', [
            'stringable' => new class() {
                public function __toString()
                {
                    return 'stringable';
                }
            }
        ]);

        $this->assertEquals('This is an interpolated text ...', $text1);
        $this->assertEquals('This is an interpolated text with a different placeholder ...', $text2);
        $this->assertEquals('This is an interpolated text with a different placeholder ...', $text3);
        $this->assertEquals('This is [text] with a different placeholder ...', $text4);
        $this->assertEquals('This is a value of an object {"value":"object"} (JSON)', $text5);
        $this->assertEquals('This is a value of a stringable', $text6);
    }

    public function testTransformMethod()
    {
        $clean      = Utility::transform('TestString-num.1', 'clean');
        $alnum      = Utility::transform('Test@123', 'alnum');
        $alpha      = Utility::transform('Test123', 'alpha');
        $numeric    = Utility::transform('Test123', 'numeric');
        $slug       = Utility::transform('Test+String', 'slug');
        $sentence   = Utility::transform('Test+String', 'sentence');
        $title      = Utility::transform('test string', 'title');
        $pascal     = Utility::transform('test string', 'pascal');
        $camel      = Utility::transform('test string', 'camel');
        $constant   = Utility::transform('Test String', 'constant');
        $cobol      = Utility::transform('Test String', 'cobol');
        $train      = Utility::transform('Test String', 'train');
        $snake      = Utility::transform('Test String', 'snake');
        $kebab      = Utility::transform('Test String', 'kebab');
        $dot        = Utility::transform('Test String', 'dot');
        $spaceless  = Utility::transform('Test String', 'spaceless');
        $lower      = Utility::transform('Test String', 'lower');
        $upper      = Utility::transform('Test String', 'upper');
        $strtolower = Utility::transform('Test String', 'strtolower');
        $mixed      = Utility::transform('Test String', 'trim', 'slug', 'sentence');

        $this->assertEquals('Test String num 1', $clean);
        $this->assertEquals('Test123', $alnum);
        $this->assertEquals('Test', $alpha);
        $this->assertEquals('123', $numeric);
        $this->assertEquals('test-string', $slug);
        $this->assertEquals('Test string', $sentence);
        $this->assertEquals('Test String', $title);
        $this->assertEquals('TestString', $pascal);
        $this->assertEquals('testString', $camel);
        $this->assertEquals('TEST_STRING', $constant);
        $this->assertEquals('TEST-STRING', $cobol);
        $this->assertEquals('Test-String', $train);
        $this->assertEquals('test_string', $snake);
        $this->assertEquals('test-string', $kebab);
        $this->assertEquals('test.string', $dot);
        $this->assertEquals('TestString', $spaceless);
        $this->assertEquals('test string', $lower);
        $this->assertEquals('TEST STRING', $upper);
        $this->assertEquals('test string', $strtolower);
        $this->assertEquals('Test string', $mixed);
    }


    private function getTestArray(): array
    {
        return [
            'item1' => 'test',
            'item2' => 123,
            'item3' => [
                'sub1' => true,
                'sub2' => false,
                'sub3' => [
                    'nested1' => null
                ],
            ],
            'item4.sub1' => [
                'nested1' => true,
                'nested2' => false,
            ],
            'item5' => null,
        ];
    }

    private function getInjectionTestData(): array
    {
        return [
            'null'   => null,
            'true'   => true,
            'false'  => false,
            'string' => 'string',
            'array'  => [],
            '@array' => [
                'item' => 'value',
            ],
        ];
    }
}

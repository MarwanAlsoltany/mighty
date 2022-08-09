<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests\Support;

use MAKS\Mighty\Support\Serializer;
use MAKS\Mighty\TestCase;

class SerializerTest extends TestCase
{
    public function testSerliazerSerializeMethod(): void
    {
        $this->assertEquals('null', Serializer::serialize(null));
        $this->assertEquals('true', Serializer::serialize(true));
        $this->assertEquals('false', Serializer::serialize(false));
        $this->assertEquals('123', Serializer::serialize(123));
        $this->assertEquals('"string"', Serializer::serialize('string'));
        $this->assertEquals('[1,2,3]', Serializer::serialize([1, 2, 3]));
        $this->assertEquals('{"key":"value"}', Serializer::serialize(['key' => 'value']));
        $this->assertEquals('{}', Serializer::serialize(new \stdClass()));
        $this->assertEquals('"value"', Serializer::serialize(new class() {
            public function __toString() { return 'value'; }
        }));
    }

    public function testSerliazerUnserializeMethod(): void
    {
        $this->assertEquals(null, Serializer::unserialize('null'));
        $this->assertEquals(true, Serializer::unserialize('true'));
        $this->assertEquals(false, Serializer::unserialize('false'));
        $this->assertEquals(123, Serializer::unserialize('123'));
        $this->assertEquals('123', Serializer::unserialize('123', 'string'));
        $this->assertEquals('string', Serializer::unserialize('"string"'));
        $this->assertEquals('string', Serializer::unserialize('\"string\"'));
        $this->assertEquals('string', Serializer::unserialize('string'));
        $this->assertEquals([1, 2, 3], Serializer::unserialize('[1,2,3]'));
        $this->assertEquals(['key' => 'value'], Serializer::unserialize('{"key":"value"}'));
        $this->assertEquals([], Serializer::unserialize('{}'));
        $this->assertEquals(new \stdClass(), Serializer::unserialize('{}', 'object'));
    }
}

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Tests;

use MAKS\Mighty\Result;
use MAKS\Mighty\TestCase;

class ResultTest extends TestCase
{
    private Result $result;


    public function setUp(): void
    {
        parent::setUp();

        $this->result = new Result(
            value: 'value',
            result: true,
            validations: [
                'string' => true,
                'count' => true,
            ],
            errors: [],
            metadata: [
                'basis' => '!string&count:3',
                'rules' => 'string&count:3',
                'expression' => '1&1',
            ]
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->result);
    }


    public function testResultObjectStateWhenMutated(): void
    {
        $this->assertTrue(count($this->result) === 5);
        $this->assertEquals($this->result->toString(), '');
        $this->assertEquals($this->result->toArray(), [
            'value' => 'value',
            'result' => true,
            'validations' => [
                'string' => true,
                'count' => true,
            ],
            'errors' => [],
            'metadata' => [
                'basis' => '!string&count:3',
                'rules' => 'string&count:3',
                'expression' => '1&1',
            ],
        ]);

        $this->result['key']   = 'key';
        $this->result['value'] = 'test';

        $this->assertEquals('key', $this->result['key']);
        $this->assertEquals('value', $this->result['value']);
        $this->assertEquals($this->result->toArray(), [
            'key' => 'key',
            'value' => 'value',
            'result' => true,
            'validations' => [
                'string' => true,
                'count' => true,
            ],
            'errors' => [],
            'metadata' => [
                'basis' => '!string&count:3',
                'rules' => 'string&count:3',
                'expression' => '1&1',
            ],
        ]);

        foreach ($this->result as $key => $value) {
            if ($key === 'key' || $key === 'value') {
                unset($this->result[$key]);
            }
        }

        $this->assertEquals(count($this->result), 5);
        $this->assertFalse(isset($this->result['key']));
        $this->assertTrue(isset($this->result['value']));
        $this->assertIsString('value', $this->result['value']);
    }

    public function testResultObjectWhenCastedToString(): void
    {
        $result = Result::from([
            'value' => null,
            'result' => false,
            'validations' => [
                'string' => false,
                'min' => false,
            ],
            'errors' => [
                'string' => 'Data is not a string.',
                'min' => 'Data must be a string that is at least 3 characters in length.',
            ],
            'metadata' => [
                'basis' => 'string&min:3',
                'rules' => 'string&min:3',
                'expression' => '0&0',
            ]
        ]);

        $this->assertEquals(
            (string)$result,
            'Data is not a string; Data must be a string that is at least 3 characters in length.'
        );
    }
}

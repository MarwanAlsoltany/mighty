<?php

/**
 * @author %[authorName]% <%[authorEmail]%>
 * @copyright %[authorName]% %[year]%
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vendor\Package;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function __construct()
    {
        parent::__construct();

        defined('TESTING') || define('TESTING', 1);

        $this->prepareNeededSuperglobals();
    }


    /**
     * Prepares superglobals needed for testing.
     *
     * @return void
     */
    private function prepareNeededSuperglobals(): void
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'domain.tld';
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}

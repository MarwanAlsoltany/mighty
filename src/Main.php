<?php

/**
 * @author %[authorName]% <%[authorEmail]%>
 * @copyright %[authorName]% %[year]%
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vendor\Package;

use Exception;

/**
 * @package Vendor\Package
 */
class Main
{
    public function __construct()
    {
    }


    /**
     * Description.
     *
     * @param string $param Description.
     * @param string|null ...$params Description.
     *
     * @return string Description
     *
     * @throws Exception Description.
     *
     * @since x.x.x
     */
    public function method(string $param, ?string ...$params): string
    {
        return '';
    }
}

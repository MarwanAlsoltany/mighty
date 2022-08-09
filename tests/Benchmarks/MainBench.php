<?php

/**
 * @author %[authorName]% <%[authorEmail]%>
 * @copyright %[authorName]% %[year]%
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Package\Vendor\Benchmarks;

use PhpBench\Attributes as Bench;

#[Bench\Skip]
#[Bench\OutputTimeUnit('seconds')]
#[Bench\OutputMode('throughput')]
class MainBench
{
    #[Bench\Revs(500)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(5)]
    #[Bench\Groups(['something'])]
    public function benchSomething(): void
    {
        rand(0, rand());
    }
}

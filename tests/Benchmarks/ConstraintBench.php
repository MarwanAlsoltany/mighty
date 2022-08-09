<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Benchmarks;

use MAKS\Mighty\Mocks\ValidatableObject;
use MAKS\Mighty\Mocks\ValidatableObjectChild;
use PhpBench\Attributes as Bench;

#[Bench\OutputTimeUnit('seconds')]
#[Bench\OutputMode('throughput')]
class ConstraintBench
{
    #[Bench\Revs(500)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(5)]
    #[Bench\Groups(['constraint', 'valid'])]
    public function benchAValidValidatableObject(): void
    {
        $object = new ValidatableObject();
        $object->object = new ValidatableObjectChild();

        $object->isValid();
    }

    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    #[Bench\Warmup(1)]
    #[Bench\Groups(['constraint', 'invalid'])]
    public function benchAnInvalidValidatableObject(): void
    {
        $object = new ValidatableObject();
        // $object->object = new ValidatableObjectChild();

        $object->isValid();
    }
}

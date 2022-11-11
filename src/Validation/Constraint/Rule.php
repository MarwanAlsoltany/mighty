<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Constraint;

use Attribute;
use MAKS\Mighty\Engine;
use MAKS\Mighty\Result;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint\ValidatesOne;

/**
 * Validates any data using a single validation rule.
 *
 * @package Mighty\Validator
 */
#[Attribute(
    Attribute::IS_REPEATABLE |
    Attribute::TARGET_CLASS |
    Attribute::TARGET_CLASS_CONSTANT |
    Attribute::TARGET_PROPERTY |
    Attribute::TARGET_METHOD
)]
class Rule extends Constraint implements ValidatesOne
{
    /**
     * Rule constructor.
     *
     * @param string $name
     * @param mixed[] $arguments
     * @param string|null $message
     * @param Strategy $strategy
     */
    public function __construct(
        string $name,
        ?array $arguments = null,
        ?string $message = null,
        Strategy $strategy = Strategy::FailLazy,
    ) {
        $validation = Engine::createRuleStatement($name, Engine::createRuleArguments($arguments ?? []));

        parent::__construct(validation: $validation, messages: [$name => $message], strategy: $strategy);
    }


    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value = null): Result
    {
        return parent::validate($value);
    }
}

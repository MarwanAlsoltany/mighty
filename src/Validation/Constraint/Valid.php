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
use MAKS\Mighty\Rule;
use MAKS\Mighty\Result;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectInterface;
use MAKS\Mighty\Validation\Constraint\ValidatesOne;

/**
 * Validates the validity of a validatable object.
 *
 * @package Mighty\Validator
 */
#[Attribute(
    Attribute::TARGET_PROPERTY |
    Attribute::TARGET_METHOD
)]
class Valid extends Constraint implements ValidatesOne
{
    /**
     * Valid constructor.
     *
     * @param string|null $message
     * @param Strategy $strategy
     */
    public function __construct(
        ?string $message = null,
        Strategy $strategy = Strategy::FailFast,
    ) {
        parent::__construct(validation: 'valid', messages: ['valid' => $message], strategy: $strategy);
    }


    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value = null): Result
    {
        $name        = '';
        $data        = [$name => $value];
        $validations = [$name => $this->validation];
        $messages    = [$name => [$this->validation => $this->messages[$this->validation] ?? null]];
        $labels      = [$name => static::class];

        $result = $this
            ->getValidator()
            ->addRule(
                (new Rule())
                    ->setName('valid')
                    ->setCallback(static fn ($input, $interface) => $input instanceof $interface && $input->isValid())
                    ->setParameters(['@input', ValidatableObjectInterface::class])
                    ->setMessage('${@label} validation failed or the value is not a instance of ${@parameters.1}')
            )
            ->setData($data)
            ->setValidations($validations)
            ->setMessages($messages)
            ->setLabels($labels)
            ->validate();

        return $result[$name];
    }
}

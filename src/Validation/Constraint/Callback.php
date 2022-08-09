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
use MAKS\Mighty\Validation\Constraint\ValidatesOne;

/**
 * Validates any data using a callback function.
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
class Callback extends Constraint implements ValidatesOne
{
    /**
     * Callback constructor.
     *
     * @param string|array<string,string> $callback
     * @param string|null $message
     * @param Strategy $strategy
     */
    public function __construct(
        private string|array $callback,
        ?string $message = null,
        Strategy $strategy = Strategy::FailLazy,
    ) {
        ($validator = clone $this->getValidator())
            ->setData([
                'callback' => $callback,
            ])
            ->setValidations([
                'callback' => $validator->validation()->required()->group(fn ($validation) => $validation->string()->xor()->array())->callable(),
            ])
            ->setLabels([
                'callback' => 'Callback',
            ])
            ->setMessages([
                'callback' => [
                    'callable' => '${@label} must be a callable in the form of string or array (constant expression)',
                ],
            ])
            ->check();

        parent::__construct(validation: 'callback', messages: ['callback' => $message], strategy: $strategy);
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

        /** @var callable $callback */
        $callback = $this->callback;
        $callback = $callback(...);

        $result = (clone $this->getValidator())
            ->addRule(
                (new Rule())
                    ->setName('callback')
                    ->setCallback($callback)
                    ->setParameters(['@input'])
                    ->setComparison(['@output', '&&', true])
                    ->setMessage('${@label}: Callback validation failed.')
            )
            ->setData($data)
            ->setValidations($validations)
            ->setMessages($messages)
            ->setLabels($labels)
            ->validate();

        return $result[$name];
    }
}

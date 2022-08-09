<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation;

use Attribute;
use Throwable;
use MAKS\Mighty\Validator;
use MAKS\Mighty\Result;
use MAKS\Mighty\Validation;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint\ValidatesAny;
use MAKS\Mighty\Validation\Constraint\ValidatesOne;
use MAKS\Mighty\Validation\Constraint\ValidatesMany;
use MAKS\Mighty\Exception\ValidationFailedException;
use MAKS\Mighty\Support\Utility;

/**
 * Validates any data using the passed validation expression.
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
class Constraint implements ValidatesAny
{
    /**
     * Constraint validation expression.
     *
     * @var string
     */
    protected string $validation;

    /**
     * Constraint rules messages overrides.
     *
     * @var array<string,string|null>
     */
    protected array $messages;

    /**
     * Constraint strategy.
     *
     * @var Strategy
     */
    protected Strategy $strategy;


    /**
     * Constraint constructor.
     *
     * @param string|Validation $validation
     * @param null|array<string,string|null> $messages
     * @param Strategy $strategy
     */
    public function __construct(
        string|Validation $validation,
        ?array $messages = null,
        Strategy $strategy = Strategy::FailFast,
    ) {
        $this->setValidation((string)$validation);
        $this->setMessages((array)$messages);
        $this->setStrategy($strategy);
    }


    /**
     * Gets constraint validation expression.
     *
     * @return string
     */
    public function getValidation(): string
    {
        return $this->validation;
    }

    /**
     * Sets constraint validation expression.
     *
     * @param string $validation
     *
     * @return static
     */
    public function setValidation(string $validation): static
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Gets constraint rules messages overrides.
     *
     * @return array<string,string|null>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Sets constraint rules messages overrides.
     *
     * @param array<string,string|null> $messages
     */
    public function setMessages(array $messages): static
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Gets constraint strategy.
     *
     * @return Strategy
     */
    public function getStrategy(): Strategy
    {
        return $this->strategy;
    }

    /**
     * Sets constraint strategy.
     *
     * @param Strategy $strategy
     *
     * @return static
     */
    public function setStrategy(Strategy $strategy): static
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return Result
     */
    public function validate(mixed $value = null): array|Result
    {
        $name        = '';
        $data        = [$name => $value];
        $validations = [$name => $this->validation];
        $messages    = [$name => $this->messages];
        $labels      = [$name => 'Value'];

        $result = (clone $this->getValidator())
            ->setData($data)
            ->setValidations($validations)
            ->setMessages($messages)
            ->setLabels($labels)
            ->validate();

        return $result[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function check(mixed $value = null): void
    {
        /** @var ValidatesOne|ValidatesMany|ValidatesAny $this */
        /** @var Result[] $validations */
        $validations = ($result = $this->validate($value)) instanceof Result ? [$result] : $result;

        foreach ($validations as $validation) {
            if ($validation->getResult() === true) {
                continue;
            }

            throw new ValidationFailedException(
                Utility::interpolate(
                    'The value ({value}) failed to pass the validation ({rules}), Problem(s): {problems}',
                    [
                        'value'    => $validation->value,
                        'rules'    => $validation->metadata['rules'],
                        'problems' => $validation,
                    ]
                )
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(mixed $value = null): bool
    {
        try {
            $this->check($value);
        } catch (Throwable) {
            return false;
        }

        return true;
    }

    /**
     * Returns the master Validator instance that should be used in validation.
     *
     * NOTE: All constraint share the same Validator.
     *      Always clone it to avoid any side effects.
     *
     * @return Validator
     */
    final protected function getValidator(): Validator
    {
        static $validator = new Validator();

        return $validator;
    }
}

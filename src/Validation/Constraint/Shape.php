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
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint\ValidatesMany;
use MAKS\Mighty\Support\Utility;

/**
 * Validates the shape of an array or object (traversable or not).
 *
 * @package Mighty\Validator
 */
#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::TARGET_CLASS_CONSTANT |
    Attribute::TARGET_PROPERTY |
    Attribute::TARGET_METHOD
)]
class Shape extends Constraint implements ValidatesMany
{
    /**
     * Shape constructor.
     *
     * @param array<string,Constraint> $fields The fields to validate.
     *      Nested elements can be accessed using dot notation (`someKey.someNestedKey`).
     *      Keys can have the wildcard `*` after a dot to match all nested keys.
     * @param bool $recursive [optional] Whether to or not to make the data recursively validatable.
     *      The data this constraint is applied to will be casted to an array recursively to allow for accessing nested data.
     * @param array|null $messages
     * @param Strategy $strategy
     */
    public function __construct(
        private array $fields,
        private bool $recursive = false,
        ?array $messages = null,
        Strategy $strategy = Strategy::FailFast,
    ) {
        ($validator = clone $this->getValidator())
            ->setData([
                'fields' => $fields,
            ])
            ->setValidations([
                'fields'   => $validator->validation()->required()->array()->min(1),
                'fields.*' => $validator->validation()->required()->object()->objectIsInstanceOf(Constraint::class),
            ])
            ->setLabels([
                'fields'   => 'Fields',
                'fields.*' => 'Fields array item',
            ])
            ->check();

        parent::__construct(validation: 'shape', messages: $messages, strategy: $strategy);
    }

    public function validate(mixed $value = null): array
    {
        $data        = $this->recursive ? Utility::castToArray($value) : (array)$value;
        $validations = [];
        $messages    = ['*' => $this->messages];
        $labels      = [];

        foreach ($this->fields as $field => $constraint) {
            $validations[$field] = $constraint->getValidation();
            $messages[$field]    = $constraint->getMessages();
            $labels[$field]      = null;
        }

        $result = (clone $this->getValidator())
            ->setData($data)
            ->setValidations($validations)
            ->setMessages($messages)
            ->setLabels($labels)
            ->validate();

        return $result;
    }
}

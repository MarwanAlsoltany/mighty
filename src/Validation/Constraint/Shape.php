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
     * @param bool $traverse [optional] Whether to traverse the validatable data.
     *      The data this constraint is applied to will be casted to an array recursively to allow for accessing nested data.
     *      Nested objects properties (and arrays keys) can be accessed using dot notation using the `$fields` parameter.
     * @param array|null $messages
     * @param Strategy $strategy
     */
    public function __construct(
        private array $fields,
        private bool $traverse = false,
        ?array $messages = null,
        Strategy $strategy = Strategy::FailFast,
    ) {
        ($validator = clone $this->getMasterValidator())
            ->setData([
                'fields' => $fields,
            ])
            ->setValidations([
                'fields'   => $validator->validation()->required()->array()->min(1),
                'fields.*' => $validator->validation()->required()->object()->callback(static fn ($input) => $input instanceof Constraint && (
                    /** @var object $input */
                    // here the check is for the actual class and not a sub-class
                    $input::class === Constraint::class ||
                    $input instanceof Rule ||
                    $input instanceof Compound
                ), 'objectType'),
            ])
            ->setLabels([
                'fields'   => 'Fields',
                'fields.*' => 'Fields array item',
            ])
            ->setMessages([
                'fields.*' => [
                    'callback.objectType' => Utility::interpolate(
                        '${@label} must be an actual instance of %constraint%, or an instance %rule% or %compound%',
                        ['constraint' => Constraint::class, 'rule' => Rule::class, 'compound' => Compound::class],
                        '%%'
                    ),
                ],
            ])
            ->check();

        parent::__construct(validation: 'shape', messages: $messages, strategy: $strategy);
    }

    public function validate(mixed $value = null): array
    {
        $data        = $this->traverse ? Utility::castToArray($value) : (array)$value;
        $validations = [];
        $messages    = ['*' => $this->messages];
        $labels      = [];

        foreach ($this->fields as $field => $constraint) {
            $validations[$field] = $constraint->getValidation();
            $messages[$field]    = $constraint->getMessages();
            $labels[$field]      = null;
        }

        $result = $this
            ->getValidator()
            ->setData($data)
            ->setValidations($validations)
            ->setMessages($messages)
            ->setLabels($labels)
            ->validate();

        return $result;
    }
}

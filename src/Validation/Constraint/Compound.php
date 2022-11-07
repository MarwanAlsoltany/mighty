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
use MAKS\Mighty\Result;
use MAKS\Mighty\Validation;
use MAKS\Mighty\Validation\Operator;
use MAKS\Mighty\Validation\Behavior;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint\Rule;
use MAKS\Mighty\Validation\Constraint\ValidatesOne;
use MAKS\Mighty\Support\Utility;

/**
 * Validates any data by compining a set of constraints to build up a Validation Expression.
 *
 * @package Mighty\Validator
 */
#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::TARGET_CLASS_CONSTANT |
    Attribute::TARGET_PROPERTY |
    Attribute::TARGET_METHOD
)]
class Compound extends Constraint implements ValidatesOne
{
    /**
     * Compound constructor.
     *
     * @param array<Constraint|Rule|Compound> $constraints The constraints to combine.
     *      Note that the supplied constraints must be an actual instance of the `Constraint::class`, or an instance `Rule::class` or `Compound::class`
     *      (only the `Compound` and `Rule` of the Special Constraint Attributes group is allowed).
     * @param Operator $operator The operator to combine with.
     * @param Behavior $behavior The behavior of the genrated validation expression.
     * @param Strategy $strategy The fail strategy of the constraint.
     */
    public function __construct(
        array $constraints,
        Operator $operator = Operator::And,
        Behavior $behavior = Behavior::Normal,
        Strategy $strategy = Strategy::FailLazy,
    ) {
        ($validator = clone $this->getValidator())
            ->setData([
                'constraints' => $constraints,
            ])
            ->setValidations([
                'constraints'   => $validator->validation()->required()->array()->min(1),
                'constraints.*' => $validator->validation()->required()->object()->callback(static fn ($input) => $input instanceof Constraint && (
                    /** @var object $input */
                    // here the check is for the actual class and not a sub-class
                    $input::class === Constraint::class ||
                    $input instanceof Rule ||
                    $input instanceof Compound
                ), 'objectType'),
            ])
            ->setLabels([
                'constraints'   => 'Constraints',
                'constraints.*' => 'Constraints array item',
            ])
            ->setMessages([
                'constraints.*' => [
                    'callback.objectType' => Utility::interpolate(
                        '${@label} must be an actual instance of %constraint%, or an instance %rule% or %compound%',
                        ['constraint' => Constraint::class, 'rule' => Rule::class, 'compound' => Compound::class],
                        '%%'
                    ),
                ],
            ])
            ->check();

        [$validation, $messages] = $this->combineConstraints($constraints, $operator, $behavior);

        parent::__construct(validation: $validation, messages: $messages, strategy: $strategy);
    }


    /**
     * @param Constraint[] $constraints
     * @param Operator $operator
     * @param Behavior $behavior
     *
     * @return array{Validation,array<string,string|null>}
     */
    private function combineConstraints(array $constraints, Operator $operator, Behavior $behavior): array
    {
        $validation = new Validation();
        $messages   = [];
        $count      = count($constraints);

        for ($i = 0; $i < $count; $i++) {
            $constraint           = $constraints[$i];
            $constraintValidation = $constraint->getValidation();
            $constraintMessages   = $constraint->getMessages();

            if ($operator === Operator::Not) {
                $validation->not();
            }

            $constraint instanceof Rule
                ? $validation->write($constraintValidation)
                : $validation->add($constraintValidation);

            ($i + 1 < $count) && match ($operator) {
                Operator::And => $validation->and(),
                Operator::Or  => $validation->or(),
                Operator::Xor => $validation->xor(),
                default       => $validation->and(),
            };

            $messages = [...$messages, ...$constraintMessages];
        }

        match ($behavior) {
            Behavior::Normal      => $validation->normal(),
            Behavior::Optimistic  => $validation->optimistic(),
            Behavior::Pessimistic => $validation->pessimistic(),
        };

        return [$validation, $messages];
    }


    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value = null): Result
    {
        return parent::validate($value);
    }
}

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Mocks;

use MAKS\Mighty\Validation\Constraint;
use MAKS\Mighty\Validation\Constraint as Assert;
use MAKS\Mighty\Validation\Strategy;
use MAKS\Mighty\Validation\Operator;
use MAKS\Mighty\Validation\Behavior;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectInterface;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectTrait;

#[Assert\Compound([
    new Assert\Rule\ObjectHasMethod('getProperty')
])]
class ValidatableObject implements ValidatableObjectInterface
{
    use ValidatableObjectTrait;


    #[Assert\Rule\Equals('CONST')]
    public const CONST = 'CONST';


    #[Assert\Rule\In(['STATIC', 'VAR'])]
    public static $static = 'VAR';


    #[Assert\Rule\StringConstraint]
    #[Assert\Rule\StringCharset('UTF-8')]
    #[Assert\Rule\Between(3, 99)]
    public $property = 'default';

    #[Assert\Rule\StringConstraint]
    #[Assert\Rule\StringContains('<catalog>')]
    #[Assert\Rule\Xml]
    public $xml = '<?xml version="1.0"?><catalog></catalog>';

    #[Assert\Rule\ArrayConstraint]
    #[Assert\Shape([
        'string' => new Assert\Rule\Str,
        'array'  => new Assert\Rule\Arr,
    ], strategy: Strategy::FailFast)]
    public $array = [
        'string' => 'value',
        'array'  => [],
    ];

    #[Assert\Rule\ObjectConstraint]
    #[Assert\Rule\ObjectIsInstanceOf(ValidatableObjectInterface::class)]
    #[Assert\Valid(message: 'Child object is invalid.', strategy: Strategy::FailLazy)]
    public $object;


    #[Assert\Callback('is_scalar', 'Data is not scalar')]
    #[Constraint('string&min:3', strategy: Strategy::FailLazy)]
    public function getProperty()
    {
        return $this->property;
    }

    #[Assert\Compound([
        new Assert\Rule\Str,
        new Assert\Compound([
            new Assert\Rule\Arr,
            new Assert\Compound([
                new Assert\Rule\Blank,
            ], Operator::Not),
        ], Operator::And),
    ], Operator::Xor, Behavior::Pessimistic, Strategy::FailLazy)]
    public static function getStaticProperty()
    {
        return static::$static;
    }
}

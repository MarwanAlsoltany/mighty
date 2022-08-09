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
use MAKS\Mighty\Validation\Constraint\ValidatableObjectInterface;
use MAKS\Mighty\Validation\Constraint\ValidatableObjectTrait;

class ValidatableObjectChild implements ValidatableObjectInterface
{
    use ValidatableObjectTrait;


    const NOT_VALIDATED = null;


    private $notValidated = self::NOT_VALIDATED;

    #[Constraint\Callback([__CLASS__, 'callback'], 'Data is not valid')]
    public $scalar = 'scalar';


    public static function callback($input)
    {
        return is_scalar($input);
    }
}

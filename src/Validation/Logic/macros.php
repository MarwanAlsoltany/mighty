<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Logic;

use MAKS\Mighty\Validation;

return [

    // null^~empty or ?(scalar|array|object|callable|resource)^null
    '[nullable]' => (new Validation())->group(static fn ($validation) => $validation->null()->xor()->not()->empty())->build(),

    // matches:"/[a-zA-Z0-9-_]+/"
    '[alnumDash]' => (new Validation())->group(static fn ($validation) => $validation->matches('/[a-zA-Z0-9-_]+/'))->build(),

    // matches:'"/^[a-zA-Z_]{1}[a-zA-Z0-9_]{0,14}$/"'
    '[twitterHandle]' => (new Validation())->group(static fn ($validation) => $validation->matches('/^[a-zA-Z_]{1}[a-zA-Z0-9_]{0,14}$/'))->build(),

    // email&string.contains:"@gmail."
    '[gmail]' => (new Validation())->group(static fn ($validation) => $validation->email()->and()->stringContains('@gmail.'))->build(),

    // email&string.endsWith:".edu"
    '[eduMail]' => (new Validation())->group(static fn ($validation) => $validation->email()->and()->stringEndsWith('.edu'))->build(),

];

<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\Mighty\Validation\Logic;

return [

    // @codeCoverageIgnoreStart
    ...(include __DIR__ . '/rules/type.php'),
    ...(include __DIR__ . '/rules/content.php'),
    ...(include __DIR__ . '/rules/filter.php'),
    ...(include __DIR__ . '/rules/filesystem.php'),
    ...(include __DIR__ . '/rules/image.php'),
    ...(include __DIR__ . '/rules/condition.php'),
    ...(include __DIR__ . '/rules/value.php'),
    ...(include __DIR__ . '/rules/count.php'),
    ...(include __DIR__ . '/rules/number.php'),
    ...(include __DIR__ . '/rules/string.php'),
    ...(include __DIR__ . '/rules/array.php'),
    ...(include __DIR__ . '/rules/object.php'),
    ...(include __DIR__ . '/rules/data.php'),
    ...(include __DIR__ . '/rules/l10n.php'),
    ...(include __DIR__ . '/rules/datetime.php'),
    ...(include __DIR__ . '/rules/color.php'),
    ...(include __DIR__ . '/rules/account.php'),
    ...(include __DIR__ . '/rules/common.php'),
    ...(include __DIR__ . '/rules/identifier.php'),
    ...(include __DIR__ . '/rules/financial.php'),
    ...(include __DIR__ . '/rules/algorithm.php'),
    ...(include __DIR__ . '/rules/php.php'),
    // @codeCoverageIgnoreEnd

];

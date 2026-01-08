<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorker\Contract;

/**
 * @see https://github.com/marcocesarato/php-conventional-changelog
 */
interface ChangelogContract
{
    public static function getChangelog(): string;
}

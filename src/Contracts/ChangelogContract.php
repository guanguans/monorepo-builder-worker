<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorker\Contracts;

/**
 * @see https://github.com/marcocesarato/php-conventional-changelog
 */
interface ChangelogContract
{
    public static function getChangelog(): string;
}

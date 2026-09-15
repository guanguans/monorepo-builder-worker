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

namespace Guanguans\MonorepoBuilderWorker\ReleaseWorker;

use Guanguans\MonorepoBuilderWorker\Contract\CheckEnvironmentContract;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Webmozart\Assert\Assert;

abstract class AbstractReleaseWorker implements CheckEnvironmentContract, ReleaseWorkerInterface
{
    final protected static function getIndexOfReleaseWorker(): int
    {
        $index = array_find_key(
            MBConfig::getUserWorkerClasses(),
            static fn (string $workerClass): bool => static::class === $workerClass
        );
        Assert::notNull($index, \sprintf('The release worker "%s" must be registered in the configuration.', static::class));
        Assert::integer($index);

        return $index;
    }
}

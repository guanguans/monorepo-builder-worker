<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorker\Support;

use Guanguans\MonorepoBuilderWorker\Contract\CheckReleaseWorkerEnvironmentInterface;

class Utils
{
    /**
     * @param array<class-string|object> $workers
     *
     * @throws \Throwable
     * @throws \MonorepoBuilderPrefix202304\Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function checkReleaseWorkersEnvironment(array $workers): void
    {
        foreach ($workers as $worker) {
            is_subclass_of($worker, CheckReleaseWorkerEnvironmentInterface::class) and $worker::check();
        }
    }
}

<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorker\Contract;

interface CheckReleaseWorkerEnvironmentInterface
{
    /**
     * @throws \Throwable
     * @throws \MonorepoBuilderPrefix202304\Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function check(): void;
}

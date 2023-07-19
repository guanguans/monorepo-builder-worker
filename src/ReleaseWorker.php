<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorker;

use Guanguans\MonorepoBuilderWorker\Concern\EnvironmentChecker;
use Guanguans\MonorepoBuilderWorker\Concern\ProcessRunnerFactory;
use Guanguans\MonorepoBuilderWorker\Contract\EnvironmentCheckerInterface;
use Guanguans\MonorepoBuilderWorker\Contract\ProcessRunnerFactoryInterface;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

abstract class ReleaseWorker implements EnvironmentCheckerInterface, ProcessRunnerFactoryInterface, ReleaseWorkerInterface
{
    use EnvironmentChecker;
    use ProcessRunnerFactory;

    /** @var array<array<string>|string> */
    protected static $commands = [];
}

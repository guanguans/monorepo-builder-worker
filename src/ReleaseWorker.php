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

use Guanguans\MonorepoBuilderWorker\Contract\ReleaseWorkerInterface;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Input\ArgvInput;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Output\ConsoleOutput;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

abstract class ReleaseWorker implements ReleaseWorkerInterface
{
    protected static function createProcessRunner(?SymfonyStyle $symfonyStyle = null): ProcessRunner
    {
        return new ProcessRunner($symfonyStyle ?: new SymfonyStyle(new ArgvInput(), new ConsoleOutput()));
    }
}

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

use MonorepoBuilderPrefix202304\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

interface ProcessRunnerFactoryInterface
{
    public static function createProcessRunner(?SymfonyStyle $symfonyStyle = null): ProcessRunner;
}

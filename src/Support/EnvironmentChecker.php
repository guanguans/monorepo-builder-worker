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

use Guanguans\MonorepoBuilderWorker\Contract\EnvironmentCheckerInterface;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Input\ArgvInput;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Output\ConsoleOutput;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Style\SymfonyStyle;

class EnvironmentChecker
{
    /**
     * @param array<class-string|object> $workers
     *
     * @throws \Throwable
     * @throws \MonorepoBuilderPrefix202304\Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function checks(array $workers): void
    {
        $symfonyStyle = new SymfonyStyle(new ArgvInput(), new ConsoleOutput());
        $symfonyStyle->note('Checking environment...');

        foreach ($workers as $worker) {
            self::check($worker);
        }

        $symfonyStyle->success('Environment checked!');
    }

    /**
     * @param class-string|object $worker
     *
     * @throws \Throwable
     * @throws \MonorepoBuilderPrefix202304\Symfony\Component\Process\Exception\ProcessFailedException
     */
    public static function check($worker): void
    {
        is_subclass_of($worker, EnvironmentCheckerInterface::class) and $worker::check();
    }
}

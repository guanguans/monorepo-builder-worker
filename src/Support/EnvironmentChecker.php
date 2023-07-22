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

use Guanguans\MonorepoBuilderWorker\Concern\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\Contract\EnvironmentCheckerInterface;

class EnvironmentChecker
{
    use ConcreteFactory;

    /**
     * @param array<callable|class-string|object> $workers
     *
     * @throws \Throwable
     */
    public static function checks(array $workers): void
    {
        self::createSymfonyStyle()->note('Checking environment...');

        foreach ($workers as $worker) {
            self::check($worker);
        }

        self::createSymfonyStyle()->note('Environment checked!');
    }

    /**
     * @param callable|class-string|object $worker
     *
     * @throws \Throwable
     */
    public static function check($worker): void
    {
        if (is_subclass_of($worker, EnvironmentCheckerInterface::class)) {
            $worker::check();
        }

        if (\is_callable($worker)) {
            $worker(self::class);
        }
    }
}

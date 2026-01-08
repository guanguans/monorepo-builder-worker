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

namespace Guanguans\MonorepoBuilderWorker\Support;

use Guanguans\MonorepoBuilderWorker\Concern\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\Contract\EnvironmentCheckerContract;

class EnvironmentChecker
{
    use ConcreteFactory;

    /**
     * @param list<callable|class-string<EnvironmentCheckerContract>|EnvironmentCheckerContract> $workers
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
     * @param callable|class-string<EnvironmentCheckerContract>|\Guanguans\MonorepoBuilderWorker\Contract\EnvironmentCheckerContract $worker
     *
     * @throws \Throwable
     */
    public static function check(callable|EnvironmentCheckerContract|string $worker): void
    {
        if (is_subclass_of($worker, EnvironmentCheckerContract::class)) {
            $worker::check();
        }

        if (\is_callable($worker)) {
            $worker(self::class);
        }
    }
}

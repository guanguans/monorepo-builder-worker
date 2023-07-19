<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorker\Concern;

/**
 * @mixin \Guanguans\MonorepoBuilderWorker\ReleaseWorker
 */
trait EnvironmentChecker
{
    use ProcessRunnerFactory;

    public static function check(): void
    {
        if (property_exists(static::class, 'checkCommands') && static::$checkCommands) {
            foreach ((array) static::$checkCommands as $command) {
                self::createProcessRunner()->run($command);
            }
        }
    }
}

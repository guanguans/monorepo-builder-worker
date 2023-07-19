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

use MonorepoBuilderPrefix202304\Symfony\Component\Process\ExecutableFinder;

/**
 * @mixin \Guanguans\MonorepoBuilderWorker\ReleaseWorker
 */
trait ExecutableFinderFactory
{
    /** @var null|ExecutableFinder */
    private static $executableFinder;

    public static function createExecutableFinder(): ExecutableFinder
    {
        if (! self::$executableFinder instanceof ExecutableFinder) {
            self::$executableFinder = new ExecutableFinder();
        }

        return self::$executableFinder;
    }
}

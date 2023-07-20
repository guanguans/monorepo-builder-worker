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

use MonorepoBuilderPrefix202304\Symfony\Component\Console\Input\ArgvInput;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Input\InputInterface;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Output\ConsoleOutput;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Output\OutputInterface;
use MonorepoBuilderPrefix202304\Symfony\Component\Console\Style\SymfonyStyle;
use MonorepoBuilderPrefix202304\Symfony\Component\Process\ExecutableFinder;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

/**
 * @mixin \Guanguans\MonorepoBuilderWorker\ReleaseWorker
 */
trait ConcreteFactory
{
    /** @var null|ProcessRunner */
    private static $runner;

    /** @var null|SymfonyStyle */
    private static $symfonyStyle;

    /** @var null|ExecutableFinder */
    private static $executableFinder;

    public static function createProcessRunner(?SymfonyStyle $symfonyStyle = null): ProcessRunner
    {
        if (! self::$runner instanceof ProcessRunner || $symfonyStyle instanceof SymfonyStyle) {
            self::$runner = new ProcessRunner($symfonyStyle ?: self::createSymfonyStyle());
        }

        return self::$runner;
    }

    public static function createSymfonyStyle(?InputInterface $input = null, ?OutputInterface $output = null): SymfonyStyle
    {
        if (
            ! self::$symfonyStyle instanceof SymfonyStyle
            || $input instanceof InputInterface
            || $output instanceof OutputInterface
        ) {
            self::$symfonyStyle = new SymfonyStyle(
                $input ?? new ArgvInput(),
                $output ?? new ConsoleOutput(OutputInterface::VERBOSITY_VERY_VERBOSE)
            );
        }

        return self::$symfonyStyle;
    }

    public static function createExecutableFinder(): ExecutableFinder
    {
        if (! self::$executableFinder instanceof ExecutableFinder) {
            self::$executableFinder = new ExecutableFinder();
        }

        return self::$executableFinder;
    }
}

<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorker\Concerns;

use MonorepoBuilderPrefix202507\Symfony\Component\Console\Input\ArgvInput;
use MonorepoBuilderPrefix202507\Symfony\Component\Console\Input\InputInterface;
use MonorepoBuilderPrefix202507\Symfony\Component\Console\Output\ConsoleOutput;
use MonorepoBuilderPrefix202507\Symfony\Component\Console\Output\OutputInterface;
use MonorepoBuilderPrefix202507\Symfony\Component\Console\Style\SymfonyStyle;
use MonorepoBuilderPrefix202507\Symfony\Component\Process\ExecutableFinder;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

trait ConcreteFactory
{
    protected static ?ExecutableFinder $executableFinder = null;
    protected static ?ProcessRunner $runner = null;
    protected static ?SymfonyStyle $symfonyStyle = null;

    public static function createExecutableFinder(): ExecutableFinder
    {
        if (!self::$executableFinder instanceof ExecutableFinder) {
            self::$executableFinder = new ExecutableFinder;
        }

        return self::$executableFinder;
    }

    public static function createProcessRunner(?SymfonyStyle $symfonyStyle = null): ProcessRunner
    {
        if (!self::$runner instanceof ProcessRunner || $symfonyStyle instanceof SymfonyStyle) {
            self::$runner = new ProcessRunner($symfonyStyle ?: self::createSymfonyStyle());
        }

        return self::$runner;
    }

    public static function createSymfonyStyle(?InputInterface $input = null, ?OutputInterface $output = null): SymfonyStyle
    {
        if (
            !self::$symfonyStyle instanceof SymfonyStyle
            || $input instanceof InputInterface
            || $output instanceof OutputInterface
        ) {
            self::$symfonyStyle = new SymfonyStyle(
                $input ?? new ArgvInput,
                $output ?? new ConsoleOutput(OutputInterface::VERBOSITY_VERY_VERBOSE)
            );
        }

        return self::$symfonyStyle;
    }
}

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

namespace Guanguans\MonorepoBuilderWorker\Concern;

use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpProcessRunner;
use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpSubprocessRunner;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

trait ConcreteFactory
{
    protected static ?ExecutableFinder $executableFinder = null;
    protected static ?PhpExecutableFinder $phpExecutableFinder = null;
    protected static ?ProcessRunner $staticProcessRunner = null;
    protected static ?PhpProcessRunner $staticPhpProcessRunner = null;
    protected static ?PhpSubprocessRunner $staticPhpSubprocessRunner = null;
    protected static ?SymfonyStyle $symfonyStyle = null;

    /**
     * @api
     */
    public static function createExecutableFinder(): ExecutableFinder
    {
        return self::$executableFinder ??= new ExecutableFinder;
    }

    public static function createPhpExecutableFinder(): PhpExecutableFinder
    {
        return self::$phpExecutableFinder ??= new PhpExecutableFinder;
    }

    public static function createProcessRunner(?SymfonyStyle $symfonyStyle = null): ProcessRunner
    {
        if (!self::$staticProcessRunner instanceof ProcessRunner || $symfonyStyle instanceof SymfonyStyle) {
            self::$staticProcessRunner = new ProcessRunner($symfonyStyle ?? self::createSymfonyStyle());
        }

        return self::$staticProcessRunner;
    }

    public static function createPhpProcessRunner(?SymfonyStyle $symfonyStyle = null): PhpProcessRunner
    {
        if (!self::$staticPhpProcessRunner instanceof PhpProcessRunner || $symfonyStyle instanceof SymfonyStyle) {
            self::$staticPhpProcessRunner = new PhpProcessRunner($symfonyStyle ?? self::createSymfonyStyle());
        }

        return self::$staticPhpProcessRunner;
    }

    public static function createPhpSubprocessRunner(?SymfonyStyle $symfonyStyle = null): PhpSubprocessRunner
    {
        if (!self::$staticPhpSubprocessRunner instanceof PhpSubprocessRunner || $symfonyStyle instanceof SymfonyStyle) {
            self::$staticPhpSubprocessRunner = new PhpSubprocessRunner($symfonyStyle ?? self::createSymfonyStyle());
        }

        return self::$staticPhpSubprocessRunner;
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

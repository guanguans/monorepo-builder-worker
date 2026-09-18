<?php

/** @noinspection SensitiveParameterInspection */
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

use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpProcessRunner;
use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpSubprocessRunner;
use Guanguans\MonorepoBuilderWorker\ProcessRunner\ProcessRunner;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\ExecutableFinder;
use Symplify\MonorepoBuilder\Config\MBConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @api
 */
final class Utils
{
    /**
     * @see \Illuminate\Console\Application::artisanBinary()
     * @see \Illuminate\Console\Application::phpBinary()
     * @see \Illuminate\Support\Composer::findComposer()
     *
     * @param list<string> $extraDirs
     *
     * @noinspection PhpUndefinedNamespaceInspection
     */
    public static function findComposer(string $name = 'composer', string $default = 'composer', array $extraDirs = []): string
    {
        return (new ExecutableFinder)->find($name, $default, $extraDirs) ?? $default;
    }

    /**
     * @see \Symplify\MonorepoBuilder\Config\MBConfig::workers()
     */
    public static function idOfReleaseWorkerFor(int $index): string
    {
        return "user_release_worker.$index";
    }

    public static function configureCommon(MBConfig $mbConfig): void
    {
        // $mbConfig->parameters()->set('$symfonyStyle', service(SymfonyStyle::class));
        $services = $mbConfig->services();
        $services->set(PhpProcessRunner::class)->arg('$symfonyStyle', service(SymfonyStyle::class));
        $services->set(PhpSubprocessRunner::class)->arg('$symfonyStyle', service(SymfonyStyle::class));
        $services->set(ProcessRunner::class)->arg('$symfonyStyle', service(SymfonyStyle::class));
    }
}

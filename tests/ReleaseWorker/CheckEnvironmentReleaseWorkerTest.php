<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpExpressionAlwaysNullInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2023-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CheckEnvironmentReleaseWorker;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CreateGithubReleaseReleaseWorker;
use PharIo\Version\Version;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

it('can configure', function (): void {
    $mockServices = Mockery::spy(ServicesConfigurator::class);
    $mockServices->allows('get')->andReturns(Mockery::spy(ServiceConfigurator::class));

    $mockMBConfig = Mockery::spy(MBConfig::class);
    $mockMBConfig->allows('services')->andReturns($mockServices);

    (static fn (): array => self::$userWorkerClasses = [
        CheckEnvironmentReleaseWorker::class,
        CreateGithubReleaseReleaseWorker::class,
    ])->bindTo(null, MBConfig::class)();
    expect(CheckEnvironmentReleaseWorker::configure($mockMBConfig))->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    expect(new CheckEnvironmentReleaseWorker(
        [new CreateGithubReleaseReleaseWorker(Mockery::spy(ProcessRunner::class), Mockery::spy(SymfonyStyle::class))],
        Mockery::spy(SymfonyStyle::class)
    ))->work(Mockery::spy(Version::class))->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    expect(new CheckEnvironmentReleaseWorker([], Mockery::spy(SymfonyStyle::class)))
        ->getDescription(Mockery::spy(Version::class))->toBeString();
})->group(__DIR__, __FILE__);

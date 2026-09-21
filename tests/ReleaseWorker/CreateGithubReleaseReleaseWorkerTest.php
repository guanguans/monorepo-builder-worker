<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2023-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

use Guanguans\MonorepoBuilderWorker\ReleaseWorker\BuildLaravelZeroAppReleaseWorker;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CreateGithubReleaseReleaseWorker;
use PharIo\Version\Version;
use Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

it('can configure', function (): void {
    $mockService = Mockery::mock(ServiceConfigurator::class);
    $mockService->allows('arg')->andReturns($mockService);

    $mockServices = Mockery::mock(ServicesConfigurator::class);
    $mockServices->allows('alias')->andReturns(Mockery::mock(AliasConfigurator::class));
    $mockServices->allows('set')->andReturns($mockService);
    $mockServices->allows('get')->andReturns($mockService);

    $mockMBConfig = Mockery::mock(MBConfig::class);
    $mockMBConfig->allows('services')->andReturns($mockServices);

    (static fn (): array => self::$userWorkerClasses = [
        BuildLaravelZeroAppReleaseWorker::class,
        CreateGithubReleaseReleaseWorker::class,
    ])->bindTo(null, MBConfig::class)();

    expect(CreateGithubReleaseReleaseWorker::configure($mockMBConfig, [__FILE__]))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check', function (): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('output');

    expect(new CreateGithubReleaseReleaseWorker($mockProcessRunner))
        ->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('output');

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new CreateGithubReleaseReleaseWorker($mockProcessRunner, [__FILE__]))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new CreateGithubReleaseReleaseWorker(Mockery::mock(ProcessRunner::class)))
        ->getDescription($mockVersion)->toBeString();
})->group(__DIR__, __FILE__);

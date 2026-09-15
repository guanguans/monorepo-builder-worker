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

use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpSubprocessRunner;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\BuildLaravelZeroAppReleaseWorker;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CreateGithubReleaseReleaseWorker;
use PharIo\Version\Version;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;

it('can configure', function (): void {
    $mockService = Mockery::mock(ServiceConfigurator::class);
    $mockService->allows('arg')->andReturns($mockService);

    $mockServices = Mockery::mock(ServicesConfigurator::class);
    $mockServices->allows('set')->andReturns($mockService);
    $mockServices->allows('get')->andReturns($mockService);

    $mockMBConfig = Mockery::mock(MBConfig::class);
    $mockMBConfig->allows('services')->andReturns($mockServices);

    (static fn (): array => self::$userWorkerClasses = [
        BuildLaravelZeroAppReleaseWorker::class,
        CreateGithubReleaseReleaseWorker::class,
    ])->bindTo(null, MBConfig::class)();

    expect(BuildLaravelZeroAppReleaseWorker::configure($mockMBConfig, 'app-name', 'user-composer'))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check', function (): void {
    $mockPhpSubprocessRunner = Mockery::mock(PhpSubprocessRunner::class);
    $mockPhpSubprocessRunner->allows('run')->andReturns('output');

    expect(new BuildLaravelZeroAppReleaseWorker($mockPhpSubprocessRunner, 'app-name', 'user-composer'))
        ->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockPhpSubprocessRunner = Mockery::mock(PhpSubprocessRunner::class);
    $mockPhpSubprocessRunner->allows('run')->andReturns('output-1.0.0');

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new BuildLaravelZeroAppReleaseWorker($mockPhpSubprocessRunner, 'app-name', 'user-composer'))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new BuildLaravelZeroAppReleaseWorker(Mockery::mock(PhpSubprocessRunner::class), 'app-name', 'user-composer'))
        ->getDescription($mockVersion)->toBeString();
})->group(__DIR__, __FILE__);

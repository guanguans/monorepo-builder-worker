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

use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpSubprocessRunner;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\BuildLaravelZeroAppReleaseWorker;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CreateGithubReleaseReleaseWorker;
use PharIo\Version\Version;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;

it('can configure', function (): void {
    $mockServices = Mockery::spy(ServicesConfigurator::class);
    $mockServices->allows('set')->andReturns(Mockery::spy(ServiceConfigurator::class));
    $mockServices->allows('get')->andReturns(Mockery::spy(ServiceConfigurator::class));

    $mockMBConfig = Mockery::spy(MBConfig::class);
    $mockMBConfig->allows('services')->andReturns($mockServices);

    (static fn (): array => self::$userWorkerClasses = [
        BuildLaravelZeroAppReleaseWorker::class,
        CreateGithubReleaseReleaseWorker::class,
    ])->bindTo(null, MBConfig::class)();
    expect(BuildLaravelZeroAppReleaseWorker::configure($mockMBConfig, 'app-name', [], 'user-composer'))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check', function (): void {
    expect(new BuildLaravelZeroAppReleaseWorker(
        Mockery::spy(PhpSubprocessRunner::class),
        Mockery::spy(SymfonyStyle::class),
        'app-name',
        [],
        'user-composer'
    ))->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    expect(new BuildLaravelZeroAppReleaseWorker(
        Mockery::spy(PhpSubprocessRunner::class),
        Mockery::spy(SymfonyStyle::class),
        'app-name',
        [],
        'user-composer'
    ))->work(Mockery::spy(Version::class))->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    expect(new BuildLaravelZeroAppReleaseWorker(
        Mockery::spy(PhpSubprocessRunner::class),
        Mockery::spy(SymfonyStyle::class),
        'app-name',
        [],
        'user-composer'
    ))->getDescription(Mockery::spy(Version::class))->toBeString();
})->group(__DIR__, __FILE__);

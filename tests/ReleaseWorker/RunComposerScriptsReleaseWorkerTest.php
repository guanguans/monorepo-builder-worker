<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpExpressionAlwaysNullInspection */
/** @noinspection PhpParamsInspection */
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
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\RunComposerScriptsReleaseWorker;
use PharIo\Version\Version;
use Symfony\Component\DependencyInjection\Loader\Configurator\AliasConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symfony\Component\Process\PhpSubprocess;
use Symplify\MonorepoBuilder\Config\MBConfig;

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
        RunComposerScriptsReleaseWorker::class,
    ])->bindTo(null, MBConfig::class)();

    expect(RunComposerScriptsReleaseWorker::configure($mockMBConfig, 'composer-script', 'user-composer'))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check', function (): void {
    $mockPhpSubprocessRunner = Mockery::mock(PhpSubprocessRunner::class);
    $mockPhpSubprocessRunner->allows('run')->andReturns('output');

    expect(new RunComposerScriptsReleaseWorker($mockPhpSubprocessRunner, ['composer-script'], 'user-composer'))
        ->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockPhpSubprocessRunner = Mockery::mock(PhpSubprocessRunner::class);
    // $mockPhpSubprocessRunner->allows('withTap')->andReturnSelf();
    $mockPhpSubprocessRunner
        ->allows()
        ->withTap(Mockery::on(function (Closure $tap): bool {
            $tap($phpSubprocess = new PhpSubprocess(['composer', '--version']));
            expect($phpSubprocess)
                ->getEnv()->toHaveKey('COMPOSER_MEMORY_LIMIT', -1)
                ->getTimeout()->toBe(600.0);

            return true;
        }))
        ->andReturnSelf();
    $mockPhpSubprocessRunner->allows('run')->andReturns('output');

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new RunComposerScriptsReleaseWorker($mockPhpSubprocessRunner, ['composer-script'], 'user-composer'))
        ->work($mockVersion)->toBeNull();

    expect(new RunComposerScriptsReleaseWorker(Mockery::spy(PhpSubprocessRunner::class), ['composer-script'], 'user-composer'))
        ->work(Mockery::spy(Version::class))->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new RunComposerScriptsReleaseWorker(Mockery::mock(PhpSubprocessRunner::class), ['composer-script'], 'user-composer'))
        ->getDescription($mockVersion)->toBeString();
})->group(__DIR__, __FILE__);

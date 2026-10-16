<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
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
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\UpdateChangelogViaPhpReleaseWorker;
use PharIo\Version\Version;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

it('can configure', function (): void {
    $mockServices = Mockery::spy(ServicesConfigurator::class);
    $mockServices->allows('set')->andReturns(Mockery::spy(ServiceConfigurator::class));

    $mockMBConfig = Mockery::spy(MBConfig::class);
    $mockMBConfig->allows('services')->andReturns($mockServices);

    expect(UpdateChangelogViaPhpReleaseWorker::configure($mockMBConfig))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check', function (): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('');

    $mockPhpSubprocessRunner = Mockery::mock(PhpSubprocessRunner::class);
    $mockPhpSubprocessRunner->allows('run')->andReturns('output');

    expect(new UpdateChangelogViaPhpReleaseWorker($mockProcessRunner, $mockPhpSubprocessRunner))
        ->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (string $changelog): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns($changelog);

    $mockPhpSubprocessRunner = Mockery::mock(PhpSubprocessRunner::class);
    $mockPhpSubprocessRunner->allows('run')->andReturns($changelog);

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaPhpReleaseWorker($mockProcessRunner, $mockPhpSubprocessRunner))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__)->with([
    'invalid changelog' => [
        <<<'changelog'
            +### Feat
            changelog,
    ],
    'valid changelog' => [
        <<<'changelog'
            +### Feat
            +* **Contract:** Add ChangelogInterface
            changelog,
    ],
]);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaPhpReleaseWorker(
        Mockery::mock(ProcessRunner::class),
        Mockery::mock(PhpSubprocessRunner::class)
    ))->getDescription($mockVersion)->toBeString();
})->group(__DIR__, __FILE__);

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
    expect(new UpdateChangelogViaPhpReleaseWorker(
        Mockery::spy(ProcessRunner::class),
        Mockery::spy(PhpSubprocessRunner::class)
    ))->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (string $changelog): void {
    $mockProcessRunner = Mockery::spy(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns($changelog);

    expect(new UpdateChangelogViaPhpReleaseWorker(
        $mockProcessRunner,
        Mockery::spy(PhpSubprocessRunner::class)
    ))->work(Mockery::spy(Version::class))->toBeNull();
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
    expect(new UpdateChangelogViaPhpReleaseWorker(
        Mockery::spy(ProcessRunner::class),
        Mockery::spy(PhpSubprocessRunner::class)
    ))->getDescription(Mockery::spy(Version::class))->toBeString();
})->group(__DIR__, __FILE__);

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

use Guanguans\MonorepoBuilderWorker\Concern\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CreateGithubReleaseReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

pest()->use(ConcreteFactory::class);

it('can check', function (): void {
    (function (): void {
        $mockProcessRunner = Mockery::mock(ProcessRunner::class);
        $mockProcessRunner->allows('run')->andReturns('output');

        self::$runner = $mockProcessRunner;
    })->call(new CreateGithubReleaseReleaseWorker(Mockery::mock(ProcessRunner::class)));

    expect(CreateGithubReleaseReleaseWorker::check())->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('output');

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new CreateGithubReleaseReleaseWorker($mockProcessRunner))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new CreateGithubReleaseReleaseWorker(Mockery::mock(ProcessRunner::class)))
        ->getDescription($mockVersion)->toBeString();
})->group(__DIR__, __FILE__);

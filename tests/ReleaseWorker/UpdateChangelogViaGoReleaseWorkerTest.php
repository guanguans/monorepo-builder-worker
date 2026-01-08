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
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\UpdateChangelogViaGoReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

pest()->use(ConcreteFactory::class);

it('can check', function (): void {
    (function (): void {
        $mockProcessRunner = Mockery::mock(ProcessRunner::class);
        $mockProcessRunner->allows('run')->andReturns('output');

        self::$runner = $mockProcessRunner;
    })->call(new UpdateChangelogViaGoReleaseWorker(Mockery::mock(ProcessRunner::class)));

    expect(UpdateChangelogViaGoReleaseWorker::check())->toBeNull();
})->group(__DIR__, __FILE__);

it('can get changelog', function (): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    (function (): void {
        self::$changelog = <<<'changelog'
            ### Feat
            changelog;
    })->call(new UpdateChangelogViaGoReleaseWorker($mockProcessRunner));
    expect(UpdateChangelogViaGoReleaseWorker::getChangelog())->toBeEmpty();

    (function (): void {
        self::$changelog = <<<'changelog'
            ### Feat
            - **Contract:** Add ChangelogInterface
            changelog;

        $mockVersion = Mockery::mock(Version::class);
        $mockVersion->allows('getOriginalString')->andReturns('1.0.0');
        self::$version = $mockVersion;
    })->call(new UpdateChangelogViaGoReleaseWorker($mockProcessRunner));
    expect(UpdateChangelogViaGoReleaseWorker::getChangelog())->toBeTruthy();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('output');

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaGoReleaseWorker($mockProcessRunner))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaGoReleaseWorker(Mockery::mock(ProcessRunner::class)))
        ->getDescription($mockVersion)->toBeTruthy();
})->group(__DIR__, __FILE__);

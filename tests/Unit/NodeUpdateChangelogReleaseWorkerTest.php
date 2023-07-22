<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorkerTests\Unit;

use Guanguans\MonorepoBuilderWorker\Concern\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\NodeUpdateChangelogReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

uses(ConcreteFactory::class);

it('can check', function (): void {
    (function (): void {
        $mockProcessRunner = \Mockery::mock(ProcessRunner::class);
        $mockProcessRunner->allows('run')->andReturns('output');

        self::$runner = $mockProcessRunner;
    })->call(new NodeUpdateChangelogReleaseWorker(\Mockery::mock(ProcessRunner::class)));

    expect(NodeUpdateChangelogReleaseWorker::check())->toBeNull();
})->group(__DIR__, __FILE__);

it('can get changelog', function (): void {
    $mockProcessRunner = \Mockery::mock(ProcessRunner::class);
    (function (): void {
        self::$changelog = '';
    })->call(new NodeUpdateChangelogReleaseWorker($mockProcessRunner));
    expect(NodeUpdateChangelogReleaseWorker::getChangelog())->toBeEmpty();

    (function (): void {
        self::$changelog = <<<'changelog'
            #  (2023-07-22)

            ##  (2023-07-22)

            ### Bug Fixes

            * **config:** Add missing newline in config.yml ([22802b1](https://github.com/guanguans/monorepo-builder-worker/commit/22802b1ac9d0701d719278e224386dfbdc67eb8e))
            changelog;
    })->call(new NodeUpdateChangelogReleaseWorker($mockProcessRunner));
    expect(NodeUpdateChangelogReleaseWorker::getChangelog())->toBeTruthy();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockProcessRunner = \Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('output');

    $mockVersion = \Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new NodeUpdateChangelogReleaseWorker($mockProcessRunner))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = \Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new NodeUpdateChangelogReleaseWorker(\Mockery::mock(ProcessRunner::class)))
        ->getDescription($mockVersion)->toBeTruthy();
})->group(__DIR__, __FILE__);

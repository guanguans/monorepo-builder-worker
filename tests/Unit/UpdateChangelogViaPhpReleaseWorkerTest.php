<?php

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

use Guanguans\MonorepoBuilderWorker\Concerns\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\UpdateChangelogViaPhpReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

uses(ConcreteFactory::class);

it('can check', function (): void {
    (function (): void {
        $mockProcessRunner = \Mockery::mock(ProcessRunner::class);
        $mockProcessRunner->allows('run')->andReturns('');

        self::$runner = $mockProcessRunner;
    })->call(new UpdateChangelogViaPhpReleaseWorker(\Mockery::mock(ProcessRunner::class)));

    expect(UpdateChangelogViaPhpReleaseWorker::check())->toBeNull();
})->group(__DIR__, __FILE__);

it('can get changelog', function (): void {
    $mockProcessRunner = \Mockery::mock(ProcessRunner::class);
    (function (): void {
        self::$changelog = <<<'changelog'
            +### Feat
            changelog;
    })->call(new UpdateChangelogViaPhpReleaseWorker($mockProcessRunner));
    expect(UpdateChangelogViaPhpReleaseWorker::getChangelog())->toBeEmpty();

    (function (): void {
        self::$changelog = <<<'changelog'
            +### Feat
            +* **Contract:** Add ChangelogInterface
            changelog;
    })->call(new UpdateChangelogViaPhpReleaseWorker($mockProcessRunner));
    expect(UpdateChangelogViaPhpReleaseWorker::getChangelog())->toBeTruthy();
})->group(__DIR__, __FILE__);

it('can work', function (): void {
    $mockProcessRunner = \Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns('output');

    $mockVersion = \Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaPhpReleaseWorker($mockProcessRunner))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__);

it('can get description', function (): void {
    $mockVersion = \Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaPhpReleaseWorker(\Mockery::mock(ProcessRunner::class)))
        ->getDescription($mockVersion)->toBeString();
})->group(__DIR__, __FILE__);

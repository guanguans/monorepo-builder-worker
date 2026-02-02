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
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\UpdateChangelogViaNodeReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

pest()->use(ConcreteFactory::class);

it('can check', function (): void {
    (function (): void {
        $mockProcessRunner = Mockery::mock(ProcessRunner::class);
        $mockProcessRunner->allows('run')->andReturns('output');

        self::$runner = $mockProcessRunner;
    })->call(new UpdateChangelogViaNodeReleaseWorker(Mockery::mock(ProcessRunner::class)));

    expect(UpdateChangelogViaNodeReleaseWorker::check())->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (string $changelog): void {
    $mockProcessRunner = Mockery::mock(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns($changelog);

    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaNodeReleaseWorker($mockProcessRunner))
        ->work($mockVersion)->toBeNull();
})->group(__DIR__, __FILE__)->with([
    'invalid changelog' => [
        <<<'changelog'
            #  (2023-07-22)

            ##  (2023-07-22)

            ### Bug Fixes
            changelog,
    ],
    'valid changelog' => [
        <<<'changelog'
            #  (2023-07-22)

            ##  (2023-07-22)

            ### Bug Fixes

            * **config:** Add missing newline in config.yml ([22802b1](https://github.com/guanguans/monorepo-builder-worker/commit/22802b1ac9d0701d719278e224386dfbdc67eb8e))
            changelog,
    ],
]);

it('can get description', function (): void {
    $mockVersion = Mockery::mock(Version::class);
    $mockVersion->allows('getOriginalString')->andReturns('1.0.0');

    expect(new UpdateChangelogViaNodeReleaseWorker(Mockery::mock(ProcessRunner::class)))
        ->getDescription($mockVersion)->toBeTruthy();
})->group(__DIR__, __FILE__);

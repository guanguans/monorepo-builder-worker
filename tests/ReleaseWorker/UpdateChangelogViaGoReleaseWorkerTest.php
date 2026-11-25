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

use Guanguans\MonorepoBuilderWorker\ReleaseWorker\UpdateChangelogViaGoReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

it('can check', function (): void {
    expect(new UpdateChangelogViaGoReleaseWorker(Mockery::spy(ProcessRunner::class)))
        ->check()->toBeNull();
})->group(__DIR__, __FILE__);

it('can work', function (string $changelog): void {
    $mockProcessRunner = Mockery::spy(ProcessRunner::class);
    $mockProcessRunner->allows('run')->andReturns($changelog);

    expect(new UpdateChangelogViaGoReleaseWorker($mockProcessRunner))
        ->work(Mockery::spy(Version::class))->toBeNull();
})->group(__DIR__, __FILE__)->with([
    'invalid changelog' => [
        <<<'changelog'
            ### Feat
            changelog,
    ],
    'valid changelog' => [
        <<<'changelog'
            ### Feat
            - **Contract:** Add ChangelogInterface
            changelog,
    ],
]);

it('can get description', function (): void {
    expect(new UpdateChangelogViaGoReleaseWorker(Mockery::spy(ProcessRunner::class)))
        ->getDescription(Mockery::spy(Version::class))->toBeTruthy();
})->group(__DIR__, __FILE__);

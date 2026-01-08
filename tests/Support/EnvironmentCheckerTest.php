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

use Guanguans\MonorepoBuilderWorker\Contract\EnvironmentCheckerContract;
use Guanguans\MonorepoBuilderWorker\Support\EnvironmentChecker;

it('can batch check environment', function (): void {
    expect(EnvironmentChecker::checks([stdClass::class]))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check environment', function (): void {
    expect(EnvironmentChecker::check(stdClass::class))->toBeNull()
        ->and(EnvironmentChecker::check(
            new class implements EnvironmentCheckerContract {
                public static function check(): void {}
            }
        ))->toBeNull()
        ->and(EnvironmentChecker::check(function (): void {}))->toBeNull();
})->group(__DIR__, __FILE__);

<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2023-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorkerTests\Unit\Support;

use Guanguans\MonorepoBuilderWorker\Contracts\EnvironmentCheckerContract;
use Guanguans\MonorepoBuilderWorker\Support\EnvironmentChecker;

it('can batch check environment', function (): void {
    expect(EnvironmentChecker::checks([\stdClass::class]))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check environment', function (): void {
    expect(EnvironmentChecker::check(\stdClass::class))->toBeNull();
    expect(EnvironmentChecker::check(
        new class implements EnvironmentCheckerContract {
            public static function check(): void {}
        }
    ))->toBeNull();
    expect(EnvironmentChecker::check(function (): void {}))->toBeNull();
})->group(__DIR__, __FILE__);

it('can fix namespace prefix', function (): void {
    expect(
        (function (): void {
            self::fixNamespacePrefix();
        })->call(new EnvironmentChecker)
    )->toBeNull();
})->group(__DIR__, __FILE__);

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

namespace Guanguans\MonorepoBuilderWorkerTests\Unit\Support;

use Guanguans\MonorepoBuilderWorker\Contracts\EnvironmentCheckerContract;
use Guanguans\MonorepoBuilderWorker\Support\EnvironmentChecker;

it('can batch check environment', function (): void {
    expect(EnvironmentChecker::checks([\stdClass::class]))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check environment', function (): void {
    expect(EnvironmentChecker::check(\stdClass::class))->toBeNull();
    expect(EnvironmentChecker::check(
        new class() implements EnvironmentCheckerContract {
            public static function check(): void
            {
            }
        }
    ))->toBeNull();
    expect(EnvironmentChecker::check(function (): void {
    }))->toBeNull();
})->group(__DIR__, __FILE__);

it('can fix namespace prefix', function (): void {
    expect(
        (function (): void {
            self::fixNamespacePrefix();
        })->call(new EnvironmentChecker())
    )->toBeNull();
})->group(__DIR__, __FILE__);

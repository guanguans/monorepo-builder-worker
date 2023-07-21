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

use Guanguans\MonorepoBuilderWorker\Support\EnvironmentChecker;

it('can batch check environment', function (): void {
    expect(EnvironmentChecker::checks([\stdClass::class]))->toBeNull();
})->group(__DIR__, __FILE__);

it('can check environment', function (): void {
    expect(EnvironmentChecker::check(\stdClass::class))->toBeNull();
})->group(__DIR__, __FILE__);

it('can from callback check environment', function (): void {
    expect(EnvironmentChecker::checkFromCallback(static function (string $class): void {
        /** @var EnvironmentChecker::class $class */
        $class::createExecutableFinder();
    }))->toBeNull();
})->group(__DIR__, __FILE__);

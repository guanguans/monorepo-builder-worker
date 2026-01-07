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

use Illuminate\Support\Collection;
use function Guanguans\MonorepoBuilderWorker\Support\classes;

it('can get classes', function (): void {
    expect(classes(fn (string $class): bool => str($class)->startsWith('Illuminate\Support')))
        ->toBeInstanceOf(Collection::class)
        ->groupBy(fn (object $object): bool => $object instanceof ReflectionClass)
        ->toHaveCount(2);
})->group(__DIR__, __FILE__);

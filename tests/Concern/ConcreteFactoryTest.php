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
use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpProcessRunner;
use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpSubprocessRunner;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

pest()->use(ConcreteFactory::class);

it('can create executable finder', function (): void {
    expect($this::createExecutableFinder())->toBeInstanceOf(ExecutableFinder::class);
})->group(__DIR__, __FILE__);

it('can create php executable finder', function (): void {
    expect($this::createPhpExecutableFinder())->toBeInstanceOf(PhpExecutableFinder::class);
})->group(__DIR__, __FILE__);

it('can create process runner', function (): void {
    expect($this::createProcessRunner())->toBeInstanceOf(ProcessRunner::class);
})->group(__DIR__, __FILE__);

it('can create php process runner', function (): void {
    expect($this::createPhpProcessRunner())->toBeInstanceOf(PhpProcessRunner::class);
})->group(__DIR__, __FILE__);

it('can create php subprocess runner', function (): void {
    expect($this::createPhpSubprocessRunner())->toBeInstanceOf(PhpSubprocessRunner::class);
})->group(__DIR__, __FILE__);

it('can create symfony style', function (): void {
    expect([
        $this::createSymfonyStyle(),
        $this::createSymfonyStyle(new ArgvInput),
        $this::createSymfonyStyle(null, new ConsoleOutput),
    ])->toContainOnlyInstancesOf(SymfonyStyle::class);
})->group(__DIR__, __FILE__);

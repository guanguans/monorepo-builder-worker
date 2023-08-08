<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorkerTests\Unit\Concerns;

use Guanguans\MonorepoBuilderWorker\Concerns\ConcreteFactory;
use MonorepoBuilderPrefix202308\Symfony\Component\Console\Input\ArgvInput;
use MonorepoBuilderPrefix202308\Symfony\Component\Console\Output\ConsoleOutput;
use MonorepoBuilderPrefix202308\Symfony\Component\Console\Style\SymfonyStyle;
use MonorepoBuilderPrefix202308\Symfony\Component\Process\ExecutableFinder;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

uses(ConcreteFactory::class);

it('can create executable finder', function (): void {
    expect($this::createExecutableFinder())->toBeInstanceOf(ExecutableFinder::class);
})->group(__DIR__, __FILE__);

it('can create process runner', function (): void {
    expect($this::createProcessRunner())->toBeInstanceOf(ProcessRunner::class);
})->group(__DIR__, __FILE__);

it('can create symfony style', function (): void {
    expect([
        $this::createSymfonyStyle(),
        $this::createSymfonyStyle(new ArgvInput()),
        $this::createSymfonyStyle(null, new ConsoleOutput()),
    ])->each->toBeInstanceOf(SymfonyStyle::class);
})->group(__DIR__, __FILE__);

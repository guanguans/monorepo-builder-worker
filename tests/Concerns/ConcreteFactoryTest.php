<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorkerTests\Concerns;

use Guanguans\MonorepoBuilderWorker\Concerns\ConcreteFactory;
use MonorepoBuilderPrefix202408\Symfony\Component\Console\Input\ArgvInput;
use MonorepoBuilderPrefix202408\Symfony\Component\Console\Output\ConsoleOutput;
use MonorepoBuilderPrefix202408\Symfony\Component\Console\Style\SymfonyStyle;
use MonorepoBuilderPrefix202408\Symfony\Component\Process\ExecutableFinder;
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
        $this::createSymfonyStyle(new ArgvInput),
        $this::createSymfonyStyle(null, new ConsoleOutput),
    ])->each->toBeInstanceOf(SymfonyStyle::class);
})->group(__DIR__, __FILE__);

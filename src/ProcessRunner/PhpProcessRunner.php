<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorker\ProcessRunner;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\PhpProcess;

/**
 * @see \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
 */
final readonly class PhpProcessRunner
{
    /** Reasonable timeout to report hang off: 10 minutes. */
    private const TIMEOUT = 600;

    public function __construct(private SymfonyStyle $symfonyStyle) {}

    /**
     * @api
     */
    public function run(string $script, ?string $cwd = null): string
    {
        $phpProcess = $this->createPhpProcess($script, $cwd);

        if ($this->symfonyStyle->isVerbose()) {
            $this->symfonyStyle->note("Running phpProcess: {$phpProcess->getCommandLine()}");
        }

        $phpProcess->run();

        $this->reportResult($phpProcess);

        return $phpProcess->getOutput();
    }

    private function createPhpProcess(string $script, ?string $cwd): PhpProcess
    {
        return new PhpProcess($script, $cwd, null, self::TIMEOUT);
    }

    private function reportResult(PhpProcess $phpProcess): void
    {
        if ($phpProcess->isSuccessful()) {
            return;
        }

        throw new ProcessFailedException($phpProcess);
    }
}

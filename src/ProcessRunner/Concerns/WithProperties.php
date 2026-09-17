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

namespace Guanguans\MonorepoBuilderWorker\ProcessRunner\Concerns;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

/**
 * @see \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
 *
 * @template TProcess of \Symfony\Component\Process\Process
 *
 * @api
 */
trait WithProperties
{
    /** Reasonable timeout to report hang off: 10 minutes. */
    protected const TIMEOUT = 600;

    /** @var null|\Closure(TProcess): (TProcess) */
    protected ?\Closure $pipe = null;

    /** @var null|\Closure(TProcess): void */
    protected ?\Closure $tap = null;

    /** @var null|(callable('err'|'out', string): void) */
    protected $callback;

    public function __construct(private readonly SymfonyStyle $symfonyStyle) {}

    /**
     * @api
     */
    public function withPipe(?\Closure $pipe): self
    {
        $this->pipe = $pipe;

        return $this;
    }

    /**
     * @api
     */
    public function withTap(?\Closure $tap): self
    {
        $this->tap = $tap;

        return $this;
    }

    /**
     * @api
     *
     * @param null|(callable('err'|'out', string): void) $callback
     *
     * @noinspection PhpDocSignatureIsNotCompleteInspection
     */
    public function withCallback(?callable $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    protected function runProcess(Process $process): string
    {
        $process = $this->finalProcess($process);

        if ($this->symfonyStyle->isVerbose()) {
            $this->symfonyStyle->note("Running process: {$process->getCommandLine()}");
        }

        return $process->mustRun($this->callback)->getOutput();
    }

    /**
     * @param TProcess $process
     *
     * @return TProcess
     */
    protected function finalProcess(Process $process): Process
    {
        if ($this->tap instanceof \Closure) {
            ($this->tap)($process);
        }

        return $this->pipe instanceof \Closure ? ($this->pipe)($process) : $process;
    }
}

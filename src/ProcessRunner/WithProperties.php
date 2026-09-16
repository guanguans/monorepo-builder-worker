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

use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\PhpSubprocess;
use Symfony\Component\Process\Process;

trait WithProperties
{
    /** @var null|\Closure(PhpProcess|PhpSubprocess|Process): (PhpProcess|PhpSubprocess|Process) */
    protected ?\Closure $pipe = null;

    /** @var null|\Closure(PhpProcess|PhpSubprocess|Process): void */
    protected ?\Closure $tap = null;

    /** @var null|(callable('err'|'out', string): void) */
    protected $callback;

    public function withPipe(?\Closure $pipe): self
    {
        $this->pipe = $pipe;

        return $this;
    }

    public function withTap(?\Closure $tap): self
    {
        $this->tap = $tap;

        return $this;
    }

    /**
     * @param null|(callable('err'|'out', string): void) $callback
     *
     * @noinspection PhpDocSignatureIsNotCompleteInspection
     */
    public function withCallback(?callable $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    private function pipeProcess(PhpProcess|PhpSubprocess|Process $process): PhpProcess|PhpSubprocess|Process
    {
        return $this->pipe instanceof \Closure ? ($this->pipe)($process) : $process;
    }

    private function tapProcess(PhpProcess|PhpSubprocess|Process $process): PhpProcess|PhpSubprocess|Process
    {
        if ($this->tap instanceof \Closure) {
            ($this->tap)($process);
        }

        return $process;
    }
}

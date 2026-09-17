<?php

/** @noinspection ContractViolationInspection */
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

use Guanguans\MonorepoBuilderWorker\ProcessRunner\Concerns\WithProperties;
use Symfony\Component\Process\Process;

final class ProcessRunner
{
    /**
     * @use WithProperties<Process>
     */
    use WithProperties;

    /**
     * @api
     *
     * @param list<string>|string $command
     */
    public function run(array|string $command, ?string $cwd = null, mixed $input = null): string
    {
        return $this->runProcess(
            \is_string($command)
            ? Process::fromShellCommandline($command, $cwd, null, $input, self::TIMEOUT)
            : new Process($command, $cwd, null, $input, self::TIMEOUT)
        );
    }
}

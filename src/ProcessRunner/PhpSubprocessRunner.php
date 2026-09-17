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
use Symfony\Component\Process\PhpSubprocess;

final class PhpSubprocessRunner
{
    /**
     * @use WithProperties<PhpSubprocess>
     */
    use WithProperties;

    /**
     * @api
     *
     * @param list<string> $command
     * @param null|list<string> $php
     */
    public function run(array $command, ?string $cwd = null, ?array $php = null): string
    {
        return $this->runProcess(new PhpSubprocess($command, $cwd, null, self::TIMEOUT, $php));
    }
}

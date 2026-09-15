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

trait WithProperty
{
    protected int $timeout = 600;

    public function setTimeout(int $timeout): static
    {
        $this->timeout = $timeout;

        return $this;
    }
}

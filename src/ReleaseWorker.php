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

namespace Guanguans\MonorepoBuilderWorker;

use Guanguans\MonorepoBuilderWorker\Concerns\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\Contracts\EnvironmentCheckerContract;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

abstract class ReleaseWorker implements EnvironmentCheckerContract, ReleaseWorkerInterface
{
    use ConcreteFactory;
}

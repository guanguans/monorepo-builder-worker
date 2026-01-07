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

namespace Guanguans\MonorepoBuilderWorker\Support\Rectors\Case\Rule;

use PhpParser\Node;

interface RuleInterface
{
    public function shouldCase(Node $node): bool;

    public function resolveName(Node $node): string;

    public function applyName(Node $node, string $name): Node;
}

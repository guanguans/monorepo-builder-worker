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

namespace Guanguans\MonorepoBuilderWorker\Support\Rectors;

use Illuminate\Support\Collection;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\Int_;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class SimplifyListIndexRector extends AbstractRector
{
    public function __construct(
        private ValueResolver $valueResolver
    ) {}

    /**
     * @throws PoorDocumentationException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Simplify list index',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        [
                            0 => 'delimiter',
                            1 => 'orderbynull',
                            2 => 'groupbyconst',
                        ]
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        [
                            'delimiter',
                            'orderbynull',
                            'groupbyconst',
                        ]
                        CODE_SAMPLE,
                ),
            ],
        );
    }

    public function getNodeTypes(): array
    {
        return [
            Array_::class,
        ];
    }

    /**
     * @param Array_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $keys = collect($node->items)
            ->pluck('key')
            ->map(fn (?Expr $expr): mixed => $expr instanceof Expr ? $this->valueResolver->getValue($expr) : null);

        /** @noinspection NullPointerExceptionInspection */
        if (
            $keys->filter(static fn (mixed $key): bool => null !== $key && !\is_int($key))->isNotEmpty()
            || !$this->isList(
                $keys->reduce(
                    static fn (Collection $carry, ?int $key): Collection => $carry->put(
                        $key ?? ($carry->isEmpty() ? 0 : $carry->keys()->sortDesc(\SORT_NUMERIC)->first() + 1),
                        $key
                    ),
                    collect()
                )->all()
            )
        ) {
            return null;
        }

        $hasChanged = false;

        foreach ($node->items as $item) {
            if ($item->key instanceof Int_) {
                $item->key = null;
                $hasChanged = true;
            }
        }

        return $hasChanged ? null : $node;
    }

    private function isList(array $array): bool
    {
        if (\function_exists('array_is_list')) {
            return array_is_list($array);
        }

        if ([] === $array) {
            return true;
        }

        $currentKey = 0;

        foreach (array_keys($array) as $key) {
            if ($key !== $currentKey) {
                return false;
            }

            ++$currentKey;
        }

        return true;
    }
}

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

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\Exception\ShouldNotHappenException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

class TransformToInternalExceptionRector extends AbstractRector implements ConfigurableRectorInterface
{
    private array $namespace = [];

    /**
     * @throws PoorDocumentationException
     * @throws ShouldNotHappenException
     */
    final public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Transform to internal exception',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
                        throw new \InvalidArgumentException('on_headers must be callable');
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        throw new \Guanguans\MonorepoBuilderWorker\Exceptions\InvalidArgumentException('on_headers must be callable');
                        CODE_SAMPLE,
                    ['exceptionClassPattern' => 'exceptionClassPattern'],
                ),
            ],
        );
    }

    final public function configure(array $configuration): void
    {
        Assert::count($configuration, 1);
        Assert::allStringNotEmpty($configuration);
        $this->namespace = $configuration;
    }

    final public function getNodeTypes(): array
    {
        return [
            New_::class,
        ];
    }

    /**
     * @param Node\Expr\New_ $node
     */
    final public function refactor(Node $node): ?Node
    {
        $className = $this->getName($node->class);

        if (
            null === $className
            || !str_ends_with($className, 'Exception')
            || str_starts_with($className, ltrim($this->namespace[0], '\\'))
        ) {
            return null;
        }

        $node->class = new Name(
            str($this->namespace[0])->start('\\')->finish('\\')->append($node->class->getLast())->toString()
        );

        return $node;
    }
}

<?php

/** @noinspection DebugFunctionUsageInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2023-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

use Guanguans\MonorepoBuilderWorker\Support\Rectors\AddNoinspectionsDocCommentToDeclareRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\NewExceptionToNewAnonymousExtendsExceptionImplementsRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\RemoveNamespaceRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\RenameToPsrNameRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\SimplifyListIndexRector;
use PhpParser\NodeVisitor\NodeConnectingVisitor;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use Rector\Config\RectorConfig;
use Rector\NodeTypeResolver\PHPStan\Scope\Contract\NodeVisitor\ScopeResolverNodeVisitorInterface;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/src/',
        // __DIR__.'/tests/',
        // ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
        // __DIR__.'/composer-updater',
        __DIR__.'/tests.php',
    ])
    ->withPhpVersion(PhpVersion::PHP_80)
    ->withoutParallel()
    // ->withImportNames(importNames: false)
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withRules([
        // SimplifyListIndexRector::class,
    ])
    // ->withConfiguredRule(AddNoinspectionsDocCommentToDeclareRector::class, [
    //     'AnonymousFunctionStaticInspection',
    //     'PhpUndefinedClassInspection',
    //     'PhpUnhandledExceptionInspection',
    //     'StaticClosureCanBeUsedInspection',
    //     'NullPointerExceptionInspection',
    //     'PhpPossiblePolymorphicInvocationInspection',
    // ])
    // ->withConfiguredRule(NewExceptionToNewAnonymousExtendsExceptionImplementsRector::class, [
    //     'Guanguans\MonorepoBuilderWorker\Contracts\ThrowableContract',
    // ])
    // ->withConfiguredRule(RemoveNamespaceRector::class, [
    //     'Guanguans\MonorepoBuilderWorkerTests',
    // ])
    ->registerService(className: ParentConnectingVisitor::class, tag: ScopeResolverNodeVisitorInterface::class)
    ->registerService(className: NodeConnectingVisitor::class, tag: ScopeResolverNodeVisitorInterface::class)
    ->withConfiguredRule(RenameToPsrNameRector::class, [
        // '*',
    ])
    ->withSkip([
        // AddNoinspectionsDocCommentToDeclareRector::class => [
        //     __DIR__.'/src/',
        //     ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
        // ],
        // RemoveNamespaceRector::class => [
        //     __DIR__.'/src/',
        //     ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
        //     __DIR__.'/tests/Faker.php',
        //     __DIR__.'/tests/TestCase.php',
        // ],
    ]);

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

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration)
    ->addPathsToScan(
        [
            // __DIR__.'/src/',
        ],
        false
    )
    ->addPathsToExclude([
        __DIR__.'/src/Support/ComposerScripts.php',
        __DIR__.'/tests/',
    ])
    ->ignoreErrorsOnPackages(
        [
            /** @see vendor/symplify/monorepo-builder/composer.json */
            'illuminate/collections',
            'phar-io/version',
            'symfony/console',
            'symfony/process',
            'webmozart/assert',
        ],
        [ErrorType::SHADOW_DEPENDENCY],
    );

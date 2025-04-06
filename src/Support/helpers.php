<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2023-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorker\Support;

use Composer\Autoload\ClassLoader;

if (!\function_exists('Guanguans\MonorepoBuilderWorker\Support\classes')) {
    /**
     * @see \get_declared_classes()
     * @see \get_declared_interfaces()
     * @see \get_declared_traits()
     *
     * @return list<class-string>
     */
    function classes(): array
    {
        static $classes;

        foreach (spl_autoload_functions() as $loader) {
            if (\is_array($loader) && $loader[0] instanceof ClassLoader) {
                return $classes ??= array_keys($loader[0]->getClassMap());
            }
        }

        return $classes ??= [];
    }
}

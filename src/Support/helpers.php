<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2023-2026 guanguans<ityaozm@gmail.com>
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
     * @see \DG\BypassFinals::enable()
     *
     * @return list<class-string>
     */
    function classes(): array
    {
        /** @var list<list<string>> $classes */
        static $classes = [];

        if ($classes) {
            return $classes;
        }

        foreach (spl_autoload_functions() as $loader) {
            if (\is_array($loader) && $loader[0] instanceof ClassLoader) {
                $classes[] = array_keys($loader[0]->getClassMap());
            }
        }

        return array_unique(array_merge(
            get_declared_classes(),
            get_declared_interfaces(),
            get_declared_traits(),
            ...$classes
        ));
    }
}

if (!\function_exists('Guanguans\MonorepoBuilderWorker\Support\rescue')) {
    /**
     * @see \Composer\Util\Silencer::call()
     */
    function rescue(callable $callback, ?callable $rescuer = null): mixed
    {
        /** @phpstan-ignore-next-line  */
        set_error_handler(static function (
            int $errNo,
            string $errStr,
            string $errFile = '',
            int $errLine = 0
        ) use ($rescuer, &$result): void {
            $rescuer and $result = $rescuer($errNo, $errStr, $errFile, $errLine);
        });

        // set_exception_handler(static function (\Throwable $throwable) use ($rescuer, &$result): void {
        //     $rescuer and $result = $rescuer($throwable);
        // });

        try {
            $result = $callback();
        } catch (\Throwable $throwable) {
            $rescuer and $result = $rescuer($throwable);
        }

        restore_error_handler();

        return $result;
    }
}

if (!\function_exists('Guanguans\MonorepoBuilderWorker\Support\str_random')) {
    /**
     * @throws \Random\RandomException
     */
    function str_random(int $length = 16): string
    {
        return substr(bin2hex(random_bytes((int) ceil($length / 2))), 0, $length);
    }
}

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
use Illuminate\Support\Collection;

if (!\function_exists('Guanguans\MonorepoBuilderWorker\Support\classes')) {
    /**
     * @see https://github.com/illuminate/collections
     * @see https://github.com/alekitto/class-finder
     * @see https://github.com/ergebnis/classy
     * @see https://gitlab.com/hpierce1102/ClassFinder
     * @see https://packagist.org/packages/haydenpierce/class-finder
     * @see \get_declared_classes()
     * @see \get_declared_interfaces()
     * @see \get_declared_traits()
     * @see \DG\BypassFinals::enable()
     * @see \Composer\Util\ErrorHandler
     * @see \Monolog\ErrorHandler
     * @see \PhpCsFixer\ExecutorWithoutErrorHandler
     * @see \Phrity\Util\ErrorHandler
     *
     * @template TObject of object
     *
     * @internal
     *
     * @param null|(callable(class-string<TObject>, string): bool) $filter
     *
     * @return \Illuminate\Support\Collection<class-string<TObject>, \ReflectionClass<TObject>|\Throwable>
     *
     * @noinspection PhpUndefinedNamespaceInspection
     */
    function classes(?callable $filter = null): Collection
    {
        $filter ??= static fn (string $class, string $file): bool => true;

        /** @var null|\Illuminate\Support\Collection<string, class-string> $classes */
        static $classes;
        $classes ??= collect(spl_autoload_functions())->flatMap(
            static fn (callable $loader): array => \is_array($loader) && $loader[0] instanceof ClassLoader
                ? $loader[0]->getClassMap()
                : []
        );

        return $classes
            ->filter(static fn (string $file, string $class): bool => $filter($class, $file))
            ->mapWithKeys(static function (string $file, string $class): array {
                try {
                    return [$class => new \ReflectionClass($class)];
                } catch (\Throwable $throwable) {
                    return [$class => $throwable];
                }
            });
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

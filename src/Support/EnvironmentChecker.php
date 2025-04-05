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

namespace Guanguans\MonorepoBuilderWorker\Support;

use Guanguans\MonorepoBuilderWorker\Concerns\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\Contracts\EnvironmentCheckerContract;

class EnvironmentChecker
{
    use ConcreteFactory;

    /**
     * @param list<callable|class-string|object> $workers
     *
     * @throws \Throwable
     */
    public static function checks(array $workers): void
    {
        try {
            self::createProcessRunner();
        } catch (\Error $error) {
            self::fixNamespacePrefix();
        }

        self::createSymfonyStyle()->note('Checking environment...');

        foreach ($workers as $worker) {
            self::check($worker);
        }

        self::createSymfonyStyle()->note('Environment checked!');
    }

    /**
     * @param callable|class-string|object $worker
     *
     * @throws \Throwable
     */
    public static function check($worker): void
    {
        if (is_subclass_of($worker, EnvironmentCheckerContract::class)) {
            $worker::check();
        }

        if (\is_callable($worker)) {
            $worker(self::class);
        }
    }

    public static function fixNamespacePrefix(): void
    {
        $yearMonth = date('Ym');

        while (202310 <= $yearMonth && !class_exists(\sprintf('MonorepoBuilderPrefix%s\Symfony\Component\Console\Style\SymfonyStyle', $yearMonth))) {
            $yearMonth = date('Ym', strtotime('-1 month', strtotime("{$yearMonth}10")));
        }

        echo \PHP_EOL, "The correct namespace prefix is [MonorepoBuilderPrefix$yearMonth].", \PHP_EOL;

        foreach (array_map('realpath', glob(__DIR__.'/../../{src,tests}{/,/*/,/*/*/,/*/*/*/}*.php', \GLOB_BRACE)) as $file) {
            $contents = file_get_contents($file);

            $replacedContents = preg_replace('/MonorepoBuilderPrefix\d{4}\d{2}/', "MonorepoBuilderPrefix$yearMonth", $contents);

            if ($replacedContents !== $contents) {
                echo "The file's [{$file}] namespace prefix is being fixed...", \PHP_EOL;
            }

            file_put_contents($file, $replacedContents);
        }

        echo 'The all files namespace prefix has been fixed.', \PHP_EOL;

        // exit(0);
    }
}

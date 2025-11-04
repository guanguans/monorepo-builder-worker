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

use Composer\InstalledVersions;
use Composer\Semver\Comparator;
use Guanguans\MonorepoBuilderWorker\Concerns\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\Contracts\EnvironmentCheckerContract;

class EnvironmentChecker
{
    use ConcreteFactory;

    /**
     * @param list<callable|class-string<EnvironmentCheckerContract>|EnvironmentCheckerContract> $workers
     *
     * @throws \Throwable
     */
    public static function checks(array $workers): void
    {
        self::checkAndFixNamespacePrefix();

        self::createSymfonyStyle()->note('Checking environment...');

        foreach ($workers as $worker) {
            self::check($worker);
        }

        self::createSymfonyStyle()->note('Environment checked!');
    }

    /**
     * @param callable|class-string<EnvironmentCheckerContract>|EnvironmentCheckerContract $worker
     *
     * @throws \Throwable
     */
    public static function check(callable|EnvironmentCheckerContract|string $worker): void
    {
        if (is_subclass_of($worker, EnvironmentCheckerContract::class)) {
            $worker::check();
        }

        if (\is_callable($worker)) {
            $worker(self::class);
        }
    }

    public static function checkAndFixNamespacePrefix(): int
    {
        try {
            self::createProcessRunner();

            return 0;
        } catch (\Error) {
            self::fixNamespacePrefix();

            return 1;
        }
    }

    private static function fixNamespacePrefix(): void
    {
        $namespacePrefix = (static function (): string {
            if (Comparator::greaterThanOrEqualTo(InstalledVersions::getPrettyVersion('symplify/monorepo-builder'), '12')) {
                return '';
            }

            $isPassed = static fn (
                string $yearMonth
            ): bool => class_exists("MonorepoBuilderPrefix$yearMonth\\Symfony\\Component\\Console\\Style\\SymfonyStyle");
            $yearMonth = date('Ym');

            while (202310 <= $yearMonth && !$isPassed($yearMonth)) {
                $yearMonth = date('Ym', strtotime('-1 month', strtotime("{$yearMonth}10")));
            }

            if (!$isPassed($yearMonth)) {
                echo \PHP_EOL, 'The file [vendor/autoload.php] is not loaded.', \PHP_EOL;

                exit(1);
            }

            return "MonorepoBuilderPrefix$yearMonth";
        })();

        echo \PHP_EOL, "The namespace prefix should be [$namespacePrefix].", \PHP_EOL;

        foreach (array_map('realpath', glob(__DIR__.'/../../{src,tests}{/,/*/,/*/*/,/*/*/*/}*.php', \GLOB_BRACE)) as $file) {
            $contents = file_get_contents($file);
            $replacedContents = preg_replace('/MonorepoBuilderPrefix\d{4}\d{2}/', $namespacePrefix, $contents);

            if ($replacedContents !== $contents) {
                file_put_contents($file, $replacedContents);
                echo "The namespace prefix of the file [$file] has been fixed", \PHP_EOL;
            }
        }
    }
}

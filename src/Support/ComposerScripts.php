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

use Composer\Script\Event;
use Rector\Config\RectorConfig;
use Rector\DependencyInjection\LazyContainerFactory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class ComposerScripts
{
    /**
     * @see \Composer\Util\Silencer
     *
     * @noinspection PhpUnused
     */
    public static function checkAndFixNamespacePrefix(?Event $event = null): int
    {
        self::requireAutoload($event);

        $exitCode = EnvironmentChecker::checkAndFixNamespacePrefix();

        0 === $exitCode and self::makeSymfonyStyle()->success('No errors');

        return $exitCode;
    }

    /**
     * @noinspection PhpUnused
     */
    public static function makeRectorConfig(): RectorConfig
    {
        return (new LazyContainerFactory)->create();
    }

    private static function makeSymfonyStyle(): SymfonyStyle
    {
        return new SymfonyStyle(new ArgvInput, new ConsoleOutput);
    }

    private static function requireAutoload(?Event $event = null): void
    {
        if ($event instanceof Event) {
            require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

            return;
        }

        $possibleAutoloadPaths = [
            __DIR__.'/../../vendor/autoload.php',
            __DIR__.'/../../../../../vendor/autoload.php',
        ];

        foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
            if (file_exists($possibleAutoloadPath)) {
                require_once $possibleAutoloadPath;

                break;
            }
        }
    }
}

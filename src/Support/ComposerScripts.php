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

namespace Guanguans\MonorepoBuilderWorker\Support;

use Composer\Script\Event;
use Rector\Config\RectorConfig;
use Rector\DependencyInjection\LazyContainerFactory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @property \Symfony\Component\Console\Output\OutputInterface $output
 */
class ComposerScripts
{
    /**
     * @see \Composer\Util\Silencer
     *
     * @noinspection PhpUnused
     */
    public static function checkAndFixNamespacePrefix(Event $event): int
    {
        self::requireAutoload($event);

        $exitCode = EnvironmentChecker::checkAndFixNamespacePrefix();

        if (0 === $exitCode) {
            // self::makeSymfonyStyle()->success('No errors');
            (fn () => $this->output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE))->call($event->getIO());
            $event->getIO()->info('');
            $event->getIO()->info('No errors');
            $event->getIO()->info('');
        }

        return $exitCode;
    }

    /**
     * @noinspection PhpUnused
     */
    public static function makeRectorConfig(): RectorConfig
    {
        return (new LazyContainerFactory)->create();
    }

    /**
     * @noinspection PhpUnused
     */
    public static function makeSymfonyStyle(): SymfonyStyle
    {
        return new SymfonyStyle(new ArgvInput, new ConsoleOutput);
    }

    public static function requireAutoload(?Event $event = null): void
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

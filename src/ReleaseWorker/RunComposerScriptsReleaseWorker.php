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

namespace Guanguans\MonorepoBuilderWorker\ReleaseWorker;

use Guanguans\MonorepoBuilderWorker\ProcessRunner\PhpSubprocessRunner;
use Guanguans\MonorepoBuilderWorker\Support\Utils;
use PharIo\Version\Version;
use Symfony\Component\Process\PhpSubprocess;
use Symplify\MonorepoBuilder\Config\MBConfig;

final class RunComposerScriptsReleaseWorker extends AbstractReleaseWorker
{
    private readonly string $composer;

    /**
     * @param non-empty-list<non-empty-string> $scripts
     */
    public function __construct(
        private readonly PhpSubprocessRunner $phpSubprocessRunner,
        // private readonly SymfonyStyle $symfonyStyle,
        private readonly array $scripts,
        ?string $composer = null,
    ) {
        $this->composer = $composer ?? Utils::findComposer();
    }

    /**
     * @api
     *
     * @param non-empty-list<non-empty-string>|non-empty-string $scripts
     * @param null|non-empty-string $composer
     */
    public static function configure(MBConfig $mbConfig, array|string $scripts, ?string $composer = null): void
    {
        Utils::configureCommon($mbConfig);
        self::getServiceConfiguratorOfReleaseWorker($mbConfig)->arg('$scripts', (array) $scripts)->arg('$composer', $composer);
    }

    public function check(): void
    {
        $this->phpSubprocessRunner->run(['-v']);
        $this->phpSubprocessRunner->run([$this->composer, '--version', '--ansi', '-v']);
    }

    public function getDescription(Version $version): string
    {
        return \sprintf('Run composer scripts: %s', implode('、', $this->scripts));
    }

    public function work(Version $version): void
    {
        $this
            ->phpSubprocessRunner
            // ->withCallback(function (string $_, string $buffer): void {
            //     $this->symfonyStyle->write($buffer);
            // })
            ->withTap(static function (PhpSubprocess $phpSubprocess): void {
                $phpSubprocess->setEnv(['COMPOSER_MEMORY_LIMIT' => -1])->setTimeout(600);
            });

        foreach ($this->scripts as $script) {
            $this->phpSubprocessRunner->run([$this->composer, 'run-script', $script, '--ansi']);
        }
    }
}

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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Webmozart\Assert\Assert;

final class BuildLaravelZeroAppReleaseWorker extends AbstractReleaseWorker
{
    private readonly string $composer;

    /**
     * @param non-empty-string $appName
     */
    public function __construct(
        private readonly PhpSubprocessRunner $phpSubprocessRunner,
        private readonly SymfonyStyle $symfonyStyle,
        private readonly string $appName,
        ?string $composer = null,
    ) {
        $this->composer = $composer ?? Utils::findComposer();
    }

    /**
     * @api
     *
     * @param non-empty-string $appName
     * @param null|non-empty-string $composer
     */
    public static function configure(MBConfig $mbConfig, string $appName, ?string $composer = null): void
    {
        Utils::configureCommon($mbConfig);
        self::getServiceConfiguratorOfReleaseWorker($mbConfig)->arg('$appName', $appName)->arg('$composer', $composer);
    }

    public function check(): void
    {
        $this->phpSubprocessRunner->run(['-v']);
        $this->phpSubprocessRunner->run([$this->appName, '--version', '--ansi', '-v']);
        $this->phpSubprocessRunner->run([$this->composer, '--version', '--ansi', '-v']);
    }

    public function getDescription(Version $version): string
    {
        return \sprintf('Build app "%s" version "%s"', $this->appName, $version->getOriginalString());
    }

    public function work(Version $version): void
    {
        register_shutdown_function(function (): void {
            $this->symfonyStyle->section('Restoring dependencies...'); // @codeCoverageIgnore
            $this->phpSubprocessRunner->run([$this->composer, 'install', '--ansi', '-v']); // @codeCoverageIgnore
            $this->phpSubprocessRunner->run([$this->appName, '--version', '--ansi', '-v']); // @codeCoverageIgnore
        });

        $this->phpSubprocessRunner->run([$this->composer, 'install', '--no-dev', '--no-scripts', '--ansi', '-v']);
        $this->phpSubprocessRunner->run([$this->appName, 'app:build', $this->appName, '--build-version', $version->getOriginalString(), '--ansi']);

        Assert::contains(
            $this->phpSubprocessRunner->run([\sprintf('builds/%s', $this->appName), '--version', '--no-ansi']),
            $version->getOriginalString(),
            \sprintf('Build app "%s" failed.', $this->appName)
        );
    }
}

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
use PharIo\Version\Version;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\ExecutableFinder;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Webmozart\Assert\Assert;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

final class BuildLaravelZeroAppReleaseWorker extends AbstractReleaseWorker
{
    private readonly string $composer;

    /**
     * @see \Illuminate\Console\Application::artisanBinary()
     * @see \Illuminate\Console\Application::phpBinary()
     * @see \Illuminate\Support\Composer::findComposer()
     *
     * @param non-empty-string $appName
     *
     * @noinspection PhpUndefinedNamespaceInspection
     */
    public function __construct(
        private readonly PhpSubprocessRunner $phpSubprocessRunner,
        private readonly string $appName,
        ?string $composer = null,
    ) {
        $this->composer = $composer ?? (new ExecutableFinder)->find('composer', 'composer') ?? 'composer';
    }

    /**
     * @see \Symplify\MonorepoBuilder\Config\MBConfig::workers()
     *
     * @api
     *
     * @param non-empty-string $appName
     * @param null|non-empty-string $composer
     */
    public static function configure(MBConfig $mbConfig, string $appName, ?string $composer = null): void
    {
        $services = $mbConfig->services();
        $services->set(PhpSubprocessRunner::class)->arg('$symfonyStyle', service(SymfonyStyle::class));

        $index = array_find_key(
            MBConfig::getUserWorkerClasses(),
            static fn (string $workerClass): bool => self::class === $workerClass
        );
        Assert::notNull($index, \sprintf('The release worker "%s" must be registered in the configuration.', self::class));
        $services->get("user_release_worker.$index")->arg('$appName', $appName)->arg('$composer', $composer);
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

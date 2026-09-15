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
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

final class RunComposerScriptsReleaseWorker extends AbstractReleaseWorker
{
    private readonly string $composer;

    /**
     * @see \Illuminate\Console\Application::artisanBinary()
     * @see \Illuminate\Console\Application::phpBinary()
     * @see \Illuminate\Support\Composer::findComposer()
     *
     * @param non-empty-list<non-empty-string> $scripts
     *
     * @noinspection PhpUndefinedNamespaceInspection
     */
    public function __construct(
        private readonly PhpSubprocessRunner $phpSubprocessRunner,
        private readonly array $scripts,
        ?string $composer = null,
    ) {
        $this->composer = $composer ?? Utils::findComposer();
    }

    /**
     * @see \Symplify\MonorepoBuilder\Config\MBConfig::workers()
     *
     * @api
     *
     * @param non-empty-list<non-empty-string>|non-empty-string $scripts
     * @param null|non-empty-string $composer
     */
    public static function configure(MBConfig $mbConfig, array|string $scripts, ?string $composer = null): void
    {
        $services = $mbConfig->services();
        $services->set(PhpSubprocessRunner::class)->arg('$symfonyStyle', service(SymfonyStyle::class));

        $index = self::getIndexOfReleaseWorker();
        $services->get("user_release_worker.$index")->arg('$scripts', (array) $scripts)->arg('$composer', $composer);
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
        foreach ($this->scripts as $script) {
            $this->phpSubprocessRunner->run([$this->composer, 'run', $script, '--ansi']);
        }
    }
}

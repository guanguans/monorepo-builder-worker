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

use Guanguans\MonorepoBuilderWorker\Contract\CheckEnvironmentContract;
use PharIo\Version\Version;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Webmozart\Assert\Assert;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

readonly class CheckEnvironmentReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @see \Symplify\MonorepoBuilder\Release\ReleaseWorkerProvider
     *
     * @param list<CheckEnvironmentContract&ReleaseWorkerInterface> $releaseWorkers
     */
    public function __construct(
        private array $releaseWorkers,
        private SymfonyStyle $symfonyStyle
    ) {}

    /**
     * @see \Symplify\MonorepoBuilder\Config\MBConfig::workers()
     *
     * @api
     */
    public static function configure(MBConfig $mbConfig): void
    {
        Assert::eq(
            array_first(MBConfig::getUserWorkerClasses()),
            self::class,
            \sprintf('The first release worker must be "%s".', self::class)
        );

        $mbConfig->services()->get('user_release_worker.0')->arg(
            '$releaseWorkers',
            array_map(
                static fn (int $index): ReferenceConfigurator => service("user_release_worker.$index"),
                array_keys(array_filter(
                    MBConfig::getUserWorkerClasses(),
                    static fn (string $workerClass): bool => is_subclass_of(
                        $workerClass,
                        CheckEnvironmentContract::class
                    )
                ))
            )
        );
    }

    public function getDescription(Version $version): string
    {
        return 'Check environment';
    }

    /**
     * @throws \Throwable
     */
    public function work(Version $version): void
    {
        foreach ($this->releaseWorkers as $releaseWorker) {
            $this->symfonyStyle->comment(\sprintf('Checking environment for "%s"...', $releaseWorker::class));
            $releaseWorker->check();
        }
    }
}

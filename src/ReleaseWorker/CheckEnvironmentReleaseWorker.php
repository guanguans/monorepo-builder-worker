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

use Guanguans\MonorepoBuilderWorker\Concern\ConcreteFactory;
use Guanguans\MonorepoBuilderWorker\Contract\CheckEnvironmentContract;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class CheckEnvironmentReleaseWorker implements ReleaseWorkerInterface
{
    use ConcreteFactory;

    /**
     * @see \Symplify\MonorepoBuilder\Release\ReleaseWorkerProvider
     *
     * @param list<CheckEnvironmentContract&ReleaseWorkerInterface> $releaseWorkers
     */
    public function __construct(private readonly array $releaseWorkers) {}

    /**
     * @see \Symplify\MonorepoBuilder\Config\MBConfig::workers()
     */
    public static function configure(MBConfig $mbConfig): void
    {
        $workerClasses = MBConfig::getUserWorkerClasses();

        \assert(
            self::class === $workerClasses[array_key_first($workerClasses)],
            \sprintf('The first release worker must be "%s".', self::class)
        );

        $releaseWorkers = [];

        foreach ($workerClasses as $index => $workerClass) {
            if (is_subclass_of($workerClass, CheckEnvironmentContract::class)) {
                $releaseWorkers[] = service("user_release_worker.$index");
            }
        }

        $mbConfig->services()->get('user_release_worker.0')->arg('$releaseWorkers', $releaseWorkers);
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
        \assert(
            \count($this->releaseWorkers) > 0,
            \sprintf('The property "%s::$releaseWorkers" must be set by calling the method "configure".', self::class)
        );

        foreach ($this->releaseWorkers as $releaseWorker) {
            self::createSymfonyStyle()->comment(\sprintf('Checking environment for "%s"...', $releaseWorker::class));
            $releaseWorker->check();
        }
    }
}

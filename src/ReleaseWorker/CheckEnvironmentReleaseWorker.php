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
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Webmozart\Assert\Assert;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class CheckEnvironmentReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @see \Symplify\MonorepoBuilder\Release\ReleaseWorkerProvider
     *
     * @param list<CheckEnvironmentContract&ReleaseWorkerInterface> $releaseWorkers
     */
    public function __construct(
        private readonly array $releaseWorkers,
        private readonly SymfonyStyle $symfonyStyle
    ) {}

    /**
     * @see \Symplify\MonorepoBuilder\Config\MBConfig::workers()
     *
     * @api
     */
    public static function configure(MBConfig $mbConfig): void
    {
        /** @var non-empty-list<class-string<ReleaseWorkerInterface>> $workerClasses */
        $workerClasses = MBConfig::getUserWorkerClasses();

        Assert::eq(
            $workerClasses[array_key_first($workerClasses)],
            self::class,
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
        // Assert::notEmpty(
        //     $this->releaseWorkers,
        //     \sprintf('The property "%s::$releaseWorkers" must be set by calling the method "configure".', self::class)
        // );
        foreach ($this->releaseWorkers as $releaseWorker) {
            $this->symfonyStyle->comment(\sprintf('Checking environment for "%s"...', $releaseWorker::class));
            $releaseWorker->check();
        }
    }
}

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
use Guanguans\MonorepoBuilderWorker\Support\Utils;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Webmozart\Assert\Assert;

abstract class AbstractReleaseWorker implements CheckEnvironmentContract, ReleaseWorkerInterface
{
    final protected static function getServiceConfiguratorOfReleaseWorker(MBConfig $mbConfig): ServiceConfigurator
    {
        $services = $mbConfig->services();
        $services->alias(static::class, $idOfReleaseWorker = self::getIdOfReleaseWorker());

        return $services->get($idOfReleaseWorker);
    }

    final protected static function getIdOfReleaseWorker(): string
    {
        $index = array_find_key(
            MBConfig::getUserWorkerClasses(),
            static fn (string $workerClass): bool => static::class === $workerClass
        );
        Assert::notNull($index, \sprintf('The release worker "%s" must be registered in the configuration.', static::class));

        return Utils::idOfReleaseWorkerFor($index);
    }
}

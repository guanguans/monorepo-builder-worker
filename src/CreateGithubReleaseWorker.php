<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\MonorepoBuilderWorker;

use Guanguans\MonorepoBuilderWorker\Contract\ReleaseWorkerInterface;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class CreateGithubReleaseWorker implements ReleaseWorkerInterface
{
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function work(Version $version): void
    {
        $this->processRunner->run(sprintf('gh release create %s --generate-notes', $version->getVersionString()));
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Create github "%s" release', $version->getVersionString());
    }
}

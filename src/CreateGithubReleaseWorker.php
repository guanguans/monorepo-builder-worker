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

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class CreateGithubReleaseWorker extends ReleaseWorker
{
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public static function checkEnvironment(): void
    {
        self::createProcessRunner()->run('gh auth status');
    }

    public function work(Version $version): void
    {
        $this->processRunner->run(sprintf(
            'gh release create %s --generate-notes',
            $version->getOriginalString()
        ));
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Create github "%s" release', $version->getOriginalString());
    }
}

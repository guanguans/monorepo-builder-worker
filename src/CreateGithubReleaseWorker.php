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
    protected static $checkCommands = [
        'gh auth status',
    ];

    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function work(Version $version): void
    {
        $this->processRunner->run("gh release create {$version->getOriginalString()} --generate-notes");
    }

    public function getDescription(Version $version): string
    {
        return "Create github release \"{$version->getOriginalString()}\"";
    }
}

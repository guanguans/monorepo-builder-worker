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

use MonorepoBuilderPrefix202304\Nette\Utils\DateTime;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class UpdateChangelogReleaseWorker extends ReleaseWorker
{
    protected static $checkCommands = [
        './vendor/bin/conventional-changelog --help',
    ];

    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function work(Version $version): void
    {
        $this->processRunner->run("./vendor/bin/conventional-changelog --ver={$version->getOriginalString()} --ansi -v");
        $this->processRunner->run("git checkout -- *.json && git add CHANGELOG.md && git commit -m \"chore(release): {$version->getOriginalString()}\" --no-verify && git push");
    }

    public function getDescription(Version $version): string
    {
        return sprintf(
            'Update `CHANGELOG.md` to "%s - %s"',
            $version->getOriginalString(),
            (new DateTime())->format('Y-m-d')
        );
    }
}

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

class UpdateChangelogReleaseWorker extends ReleaseWorker
{
    protected static $checkCommands = [
        'git rev-parse --is-inside-work-tree',
        './vendor/bin/conventional-changelog --help',
    ];

    /** @var null|string */
    protected static $changelogDiff;

    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function work(Version $version): void
    {
        $tag = $version->getOriginalString();
        $previousTag = $this->getPreviousTag($tag);

        $this->processRunner->run(sprintf(
            "./vendor/bin/conventional-changelog %s --to-tag=$tag --ver=$tag --ansi -v",
            $previousTag ? "--from-tag=$previousTag" : '--first-release'
        ));

        $this->processRunner->run("git checkout -- *.json && git add CHANGELOG.md && git commit -m \"chore(release): $tag\" --no-verify && git push");

        self::$changelogDiff = $this->processRunner->run('git show');
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }

    public static function getChangelogDiff(): ?string
    {
        return self::$changelogDiff;
    }

    protected function getPreviousTag(string $tag): string
    {
        $tags = explode(PHP_EOL, $this->processRunner->run('git tag --sort=-committerdate'));
        $previousTagIndex = array_search($tag, $tags, true) + 1;

        return $tags[$previousTagIndex] ?? '';
    }
}

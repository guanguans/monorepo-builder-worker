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

class GoUpdateChangelogReleaseWorker extends ReleaseWorker
{
    /** @var null|string */
    private static $changelogDiff;

    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public static function check(): void
    {
        self::createProcessRunner()->run('git-chglog -v');
    }

    public function work(Version $version): void
    {
        $this->processRunner->run('git-chglog --output CHANGELOG.md');
        self::$changelogDiff = $this->processRunner->run("git-chglog {$version->getOriginalString()}");
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }

    public static function getChangelogDiff(): ?string
    {
        return self::$changelogDiff;
    }

    protected function toPreviousTag(string $tag): string
    {
        $tags = explode(PHP_EOL, $this->processRunner->run('git tag --sort=-committerdate'));
        $previousTagIndex = array_search($tag, $tags, true) + 1;

        return $tags[$previousTagIndex] ?? '';
    }
}

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

use Guanguans\MonorepoBuilderWorker\Contract\ChangelogInterface;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

/**
 * @see https://github.com/git-chglog/git-chglog
 */
class GoUpdateChangelogReleaseWorker extends ReleaseWorker implements ChangelogInterface
{
    /** @var null|string */
    private static $changelog;

    /** @var null|Version */
    private static $version;

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

    public static function getChangelog(): string
    {
        if (empty(self::$changelog) || ! self::$version instanceof Version) {
            return '';
        }

        $tagPos = strpos(
            self::$changelog,
            sprintf('<a name="%s"></a>', self::$version->getOriginalString())
        );

        $subChangelog = substr(self::$changelog, (int) $tagPos, \strlen(self::$changelog));
        $replacedChangelog = preg_replace('/\s\[Unreleased\]: http?s:\/\/.*compare.*\.\.\.HEAD/', '', $subChangelog);

        return trim($replacedChangelog);
    }

    public function work(Version $version): void
    {
        $this->processRunner->run('git-chglog --output CHANGELOG.md');
        $this->processRunner->run("git add CHANGELOG.md && git commit -m \"chore(release): {$version->getOriginalString()}\" --no-verify && git push");

        self::$version = $version;
        self::$changelog = $this->processRunner->run("git-chglog {$version->getOriginalString()}");
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }
}

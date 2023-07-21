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

        return preg_replace(
            '/\[Unreleased\]: http?s:\/\/.*compare.*\.\.\.HEAD/',
            '',
            substr(self::$changelog, $tagPos, \strlen(self::$changelog))
        );
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

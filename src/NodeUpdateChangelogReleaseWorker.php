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

use Guanguans\MonorepoBuilderWorker\Contracts\ChangelogContract;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

/**
 * @see https://github.com/conventional-changelog/conventional-changelog
 */
class NodeUpdateChangelogReleaseWorker extends ReleaseWorker implements ChangelogContract
{
    /** @var null|string */
    private static $changelog;

    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public static function check(): void
    {
        self::createProcessRunner()->run('conventional-changelog --help');
    }

    public static function getChangelog(): string
    {
        if (empty(self::$changelog)) {
            return '';
        }

        $lines = array_filter(explode(PHP_EOL, self::$changelog), static function (string $line): bool {
            return ! str_starts_with($line, '# ') && ! str_starts_with($line, '## ');
        });

        $lines = implode(PHP_EOL, $lines);
        if (! str_contains($lines, '### ') || ! str_contains($lines, '* ')) {
            return '';
        }

        return trim($lines);
    }

    public function work(Version $version): void
    {
        $this->processRunner->run('conventional-changelog -p angular -i CHANGELOG.md -s -r 1');
        $this->processRunner->run("git add CHANGELOG.md && git commit -m \"chore(release): {$version->getOriginalString()}\" --no-verify && git push");

        self::$changelog = $this->processRunner->run('conventional-changelog -p angular -r 1');
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }
}

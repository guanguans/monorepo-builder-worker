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

use MonorepoBuilderPrefix202304\Webmozart\Assert\Assert;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class PhpUpdateChangelogReleaseWorker extends ReleaseWorker
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
        Assert::isEmpty(self::createProcessRunner()->run('git status --short'));
        self::createProcessRunner()->run('./vendor/bin/conventional-changelog -V');
    }

    public static function getChangelog(): string
    {
        if (empty(self::$changelog)) {
            return '';
        }

        $lines = array_filter(
            explode(PHP_EOL, self::$changelog),
            static function (string $line): bool {
                return str_starts_with($line, '+')
                    && ! str_starts_with($line, '+++')
                    && ! str_starts_with($line, '+## ');
            }
        );

        $lines = implode(
            PHP_EOL,
            array_map(static function (string $line): string {
                return ltrim($line, '+');
            }, $lines)
        );

        if (! (str_contains($lines, '### ') && str_contains($lines, '* '))) {
            return '';
        }

        return $lines;
    }

    public function work(Version $version): void
    {
        $tag = $version->getOriginalString();
        $previousTag = $this->toPreviousTag($tag);

        $this->processRunner->run(sprintf(
            "./vendor/bin/conventional-changelog %s --to-tag=$tag --ver=$tag --ansi -v",
            $previousTag ? "--from-tag=$previousTag" : '--first-release'
        ));

        $this->processRunner->run("git checkout -- *.json && git add CHANGELOG.md && git commit -m \"chore(release): $tag\" --no-verify && git push");

        self::$changelog = $this->processRunner->run('git show');
    }

    public function getDescription(Version $version): string
    {
        return sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }

    protected function toPreviousTag(string $tag): string
    {
        $tags = explode(PHP_EOL, $this->processRunner->run('git tag --sort=-committerdate'));
        $previousTagIndex = array_search($tag, $tags, true) + 1;

        return $tags[$previousTagIndex] ?? '';
    }
}

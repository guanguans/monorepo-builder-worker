<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/monorepo-builder-worker
 */

namespace Guanguans\MonorepoBuilderWorker\ReleaseWorker;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Webmozart\Assert\Assert;

/**
 * @see https://github.com/marcocesarato/php-conventional-changelog
 */
class UpdateChangelogViaPhpReleaseWorker extends AbstractReleaseWorker
{
    public function __construct(private readonly ProcessRunner $processRunner) {}

    public static function check(): void
    {
        Assert::isEmpty(self::createProcessRunner()->run('git status --short'));
        self::createProcessRunner()->run('vendor/bin/conventional-changelog -V');
    }

    final public function getDescription(Version $version): string
    {
        return \sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }

    final public function work(Version $version): void
    {
        $originalString = $version->getOriginalString();
        $previousTag = $this->toPreviousTag($originalString);

        $this->processRunner->run(\sprintf(
            "vendor/bin/conventional-changelog %s --to-tag=$originalString --ver=$originalString --ansi -v",
            $previousTag ? "--from-tag=$previousTag" : '--first-release'
        ));
        $this->processRunner->run("git checkout -- *.json && git add CHANGELOG.md && git commit -m \"chore(release): $originalString\" --no-verify && git push");

        $changelog = $this->processRunner->run('git show');
        CreateGithubReleaseReleaseWorker::setChangelog($this->sanitizeChangelog($changelog));
    }

    private function toPreviousTag(string $tag): string
    {
        $tags = explode(\PHP_EOL, $this->processRunner->run('git tag --sort=-committerdate'));
        $previousTagIndex = (int) array_search($tag, $tags, true) + 1;

        return $tags[$previousTagIndex] ?? '';
    }

    private function sanitizeChangelog(string $changelog): string
    {
        $lines = array_filter(explode(\PHP_EOL, $changelog), static fn (string $line): bool => str_starts_with($line, '+')
            && !str_starts_with($line, '+++')
            && !str_starts_with($line, '+# ')
            && !str_starts_with($line, '+## '));

        $lines = implode(\PHP_EOL, array_map(static fn (string $line): string => ltrim($line, '+'), $lines));

        if (!str_contains($lines, '### ') || !str_contains($lines, '* ')) {
            return '';
        }

        return trim($lines);
    }
}

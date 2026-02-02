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

/**
 * @see https://github.com/conventional-changelog/conventional-changelog
 */
class UpdateChangelogViaNodeReleaseWorker extends AbstractReleaseWorker
{
    public function __construct(private readonly ProcessRunner $processRunner) {}

    public static function check(): void
    {
        self::createProcessRunner()->run('conventional-changelog --help');
    }

    final public function getDescription(Version $version): string
    {
        return \sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }

    final public function work(Version $version): void
    {
        $this->processRunner->run('conventional-changelog -p angular -i CHANGELOG.md -s -r 1');
        $this->processRunner->run("git add CHANGELOG.md && git commit -m \"chore(release): {$version->getOriginalString()}\" --no-verify && git push");

        $changelog = $this->processRunner->run('conventional-changelog -p angular -r 1');
        CreateGithubReleaseReleaseWorker::setChangelog($this->sanitizeChangelog($changelog));
    }

    private function sanitizeChangelog(string $changelog): string
    {
        $lines = array_filter(explode(\PHP_EOL, $changelog), static fn (string $line): bool => !str_starts_with($line, '# ') && !str_starts_with($line, '## '));

        $lines = implode(\PHP_EOL, $lines);

        if (!str_contains($lines, '### ') || !str_contains($lines, '* ')) {
            return '';
        }

        return trim($lines);
    }
}

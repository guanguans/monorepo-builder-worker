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
 * @see https://github.com/git-chglog/git-chglog
 */
class UpdateChangelogViaGoReleaseWorker extends AbstractReleaseWorker
{
    public function __construct(private readonly ProcessRunner $processRunner) {}

    public static function check(): void
    {
        self::createProcessRunner()->run('git-chglog -v');
    }

    final public function getDescription(Version $version): string
    {
        return \sprintf('Update changelog "%s (%s)"', $version->getOriginalString(), date('Y-m-d'));
    }

    final public function work(Version $version): void
    {
        $this->processRunner->run('git-chglog --output CHANGELOG.md');
        $this->processRunner->run("git add CHANGELOG.md && git commit -m \"chore(release): {$version->getOriginalString()}\" --no-verify && git push");

        $changelog = $this->processRunner->run("git-chglog {$version->getOriginalString()}");
        CreateGithubReleaseReleaseWorker::setChangelog(self::sanitizeChangelog($changelog, $version));
    }

    public static function sanitizeChangelog(string $changelog, Version $version): string
    {
        $tagPos = strpos($changelog, \sprintf('<a name="%s"></a>', $version->getOriginalString()));
        $subChangelog = substr($changelog, (int) $tagPos, \strlen($changelog));
        $lines = array_filter(explode(\PHP_EOL, $subChangelog), static fn (string $line): bool => !str_starts_with($line, '# ') && !str_starts_with($line, '[Unreleased]: '));

        $lines = implode(\PHP_EOL, $lines);

        if (!str_contains($lines, '### ') || !str_contains($lines, '- ')) {
            return '';
        }

        return trim($lines);
    }
}

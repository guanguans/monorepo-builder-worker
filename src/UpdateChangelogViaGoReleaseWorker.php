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

namespace Guanguans\MonorepoBuilderWorker;

use Guanguans\MonorepoBuilderWorker\Contracts\ChangelogContract;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

/**
 * @see https://github.com/git-chglog/git-chglog
 */
class UpdateChangelogViaGoReleaseWorker extends ReleaseWorker implements ChangelogContract
{
    private static ?string $changelog = null;
    private static ?Version $version = null;

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

        self::$version = $version;
        self::$changelog = $this->processRunner->run("git-chglog {$version->getOriginalString()}");
    }

    public static function getChangelog(): string
    {
        if (empty(self::$changelog) || !self::$version instanceof Version) {
            return '';
        }

        $tagPos = strpos(self::$changelog, \sprintf('<a name="%s"></a>', self::$version->getOriginalString()));
        $subChangelog = substr(self::$changelog, (int) $tagPos, \strlen(self::$changelog));
        $lines = array_filter(explode(\PHP_EOL, $subChangelog), static fn (string $line): bool => !str_starts_with($line, '# ') && !str_starts_with($line, '[Unreleased]: '));

        $lines = implode(\PHP_EOL, $lines);

        if (!str_contains($lines, '### ') || !str_contains($lines, '- ')) {
            return '';
        }

        return trim($lines);
    }
}

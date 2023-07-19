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

class CreateGithubReleaseWorker extends ReleaseWorker
{
    protected static $checkCommands = [
        'git rev-parse --is-inside-work-tree',
        'gh auth status',
        'gh release list --limit 1',
    ];

    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function work(Version $version): void
    {
        $this->processRunner->run("gh release create {$version->getOriginalString()} --generate-notes");
    }

    public function getDescription(Version $version): string
    {
        return "Create github release \"{$version->getOriginalString()}\"";
    }

    protected function getChangelog(Version $version): string
    {
        // a56d0ff chore(release): 0.6.0
        $commits = array_filter(
            explode(PHP_EOL, $this->processRunner->run('git log --oneline -5')),
            static function (string $commit) use ($version): bool {
                return str_contains($commit, $version->getOriginalString());
            }
        );

        $commitId = explode(' ', array_values($commits)[0] ?? '', 2)[0];
        if (empty($commitId)) {
            return '';
        }

        $lines = array_filter(
            explode(PHP_EOL, $this->processRunner->run("git show $commitId")),
            static function (string $line): bool {
                return str_starts_with($line, '+') && ! str_starts_with($line, '+++');
            }
        );

        $lines = implode(
            PHP_EOL,
            array_map(static function (string $line): string {
                return ltrim($line, '+');
            }, $lines)
        );

        if (! (str_contains($lines, '##') && str_contains($lines, $version->getOriginalString()))) {
            return '';
        }

        return $lines;
    }
}

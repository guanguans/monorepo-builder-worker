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
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public static function check(): void
    {
        self::createProcessRunner()->run('gh auth status');
        self::createProcessRunner()->run('gh release list --limit 1');
    }

    public function work(Version $version): void
    {
        $changelog = $this->toChangelog(UpdateChangelogReleaseWorker::getChangelogDiff());

        $this->processRunner->run(array_merge(
            ['gh', 'release', 'create', $version->getOriginalString()],
            $changelog ? ['--notes', $changelog] : ['--generate-notes']
        ));
    }

    public function getDescription(Version $version): string
    {
        return "Create github release \"{$version->getOriginalString()}\"";
    }

    protected function toChangelog(?string $changelogDiff): string
    {
        $lines = array_filter(
            explode(PHP_EOL, (string) $changelogDiff),
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
}

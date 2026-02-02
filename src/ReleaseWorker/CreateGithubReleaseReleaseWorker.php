<?php

/** @noinspection PhpUnusedAliasInspection */

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

class CreateGithubReleaseReleaseWorker extends AbstractReleaseWorker
{
    private static ?string $changelog = null;

    public function __construct(private readonly ProcessRunner $processRunner) {}

    public static function check(): void
    {
        self::createProcessRunner()->run('gh auth status');
        self::createProcessRunner()->run('gh release list --limit 1');
    }

    final public function getDescription(Version $version): string
    {
        return "Create github release \"{$version->getOriginalString()}\"";
    }

    final public function work(Version $version): void
    {
        $this->processRunner->run([
            'gh', 'release', 'create', $version->getOriginalString(),
            '--title', $version->getOriginalString(),
            '--verify-tag',
            ...(self::$changelog ? ['--notes', self::$changelog] : ['--generate-notes']),
        ]);
    }

    /**
     * @param non-empty-string $changelog
     */
    public static function setChangelog(string $changelog): void
    {
        self::$changelog = $changelog;
    }
}

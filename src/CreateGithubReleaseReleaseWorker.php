<?php

declare(strict_types=1);

/**
 * Copyright (c) 2023-2025 guanguans<ityaozm@gmail.com>
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

class CreateGithubReleaseReleaseWorker extends ReleaseWorker
{
    private ProcessRunner $processRunner;

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
        $changelog = $this->findChangelog();

        $this->processRunner->run(array_merge(
            [
                'gh', 'release', 'create', $version->getOriginalString(),
                '--title', $version->getOriginalString(),
                '--verify-tag',
            ],
            $changelog ? ['--notes', $changelog] : ['--generate-notes']
        ));
    }

    public function getDescription(Version $version): string
    {
        return "Create github release \"{$version->getOriginalString()}\"";
    }

    /**
     * @noinspection NativeMemberUsageInspection
     */
    public function findChangelog(): string
    {
        foreach ([
            \stdClass::class,
            UpdateChangelogViaGoReleaseWorker::class,
            UpdateChangelogViaNodeReleaseWorker::class,
            UpdateChangelogViaPhpReleaseWorker::class,
        ] as $class) {
            if (!is_subclass_of($class, ChangelogContract::class)) {
                continue;
            }

            $changelog = $class::getChangelog();

            if (!empty($changelog)) {
                return $changelog;
            }
        }

        return '';
    }
}

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
use function Guanguans\MonorepoBuilderWorker\Support\classes;

class CreateGithubReleaseReleaseWorker extends ReleaseWorker
{
    public function __construct(private ProcessRunner $processRunner) {}

    public static function check(): void
    {
        self::createProcessRunner()->run('gh auth status');
        self::createProcessRunner()->run('gh release list --limit 1');
    }

    final public function work(Version $version): void
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

    final public function getDescription(Version $version): string
    {
        return "Create github release \"{$version->getOriginalString()}\"";
    }

    final public function findChangelog(): string
    {
        // $classes = array_filter(
        //     classes(),
        //     static fn (string $class): bool => str_starts_with($class, __NAMESPACE__)
        //         && is_subclass_of($class, ChangelogContract::class)
        // );

        $classes = [
            UpdateChangelogViaGoReleaseWorker::class,
            UpdateChangelogViaNodeReleaseWorker::class,
            UpdateChangelogViaPhpReleaseWorker::class,
        ];

        foreach ($classes as $class) {
            /** @var class-string<\Guanguans\MonorepoBuilderWorker\Contracts\ChangelogContract> $class */
            $changelog = $class::getChangelog();

            if (!empty($changelog)) {
                return $changelog;
            }
        }

        return '';
    }
}

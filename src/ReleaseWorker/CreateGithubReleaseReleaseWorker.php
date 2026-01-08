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

use Guanguans\MonorepoBuilderWorker\Contract\ChangelogContract;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use function Guanguans\MonorepoBuilderWorker\Support\classes;

class CreateGithubReleaseReleaseWorker extends AbstractReleaseWorker
{
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
        $changelog = $this->findChangelog();

        $this->processRunner->run([
            'gh', 'release', 'create', $version->getOriginalString(),
            '--title', $version->getOriginalString(),
            '--verify-tag',
            ...($changelog ? ['--notes', $changelog] : ['--generate-notes']),
        ]);
    }

    final public function findChangelog(): string
    {
        // $classes = classes(
        //     static fn (string $class): bool => str_starts_with($class, __NAMESPACE__)
        //         && is_subclass_of($class, ChangelogContract::class)
        //         && !str_ends_with($class, 'UpdateChangelogViaRustReleaseWorker')
        // )->keys();

        /** @var list<class-string<\Guanguans\MonorepoBuilderWorker\Contract\ChangelogContract>> $classes */
        $classes = [
            UpdateChangelogViaGoReleaseWorker::class,
            UpdateChangelogViaNodeReleaseWorker::class,
            UpdateChangelogViaPhpReleaseWorker::class,
        ];

        foreach ($classes as $class) {
            if ($changelog = $class::getChangelog()) {
                return $changelog;
            }
        }

        return '';
    }
}

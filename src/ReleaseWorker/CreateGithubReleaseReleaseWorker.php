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

use Nette\Utils\FileSystem;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class CreateGithubReleaseReleaseWorker extends AbstractReleaseWorker
{
    private static ?string $changelog = null;

    /**
     * @param array<int|non-empty-string, string> $files
     */
    public function __construct(
        private readonly ProcessRunner $processRunner,
        private readonly array $files = [],
    ) {}

    /**
     * @api
     *
     * @param array<int|non-empty-string, string> $files
     */
    public static function configure(MBConfig $mbConfig, array $files = []): void
    {
        self::getServiceConfiguratorOfReleaseWorker($mbConfig)->arg('$files', $files);
    }

    public function check(): void
    {
        $this->processRunner->run('gh --version');
        $this->processRunner->run('gh auth status');
        $this->processRunner->run('gh release list --limit 1');
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

        foreach ($this->files as $originalFile => $file) {
            \is_string($originalFile) and FileSystem::copy($originalFile, $file);
            $this->processRunner->run(['gh', 'release', 'upload', $version->getOriginalString(), $file]);
        }
    }

    /**
     * @param non-empty-string $changelog
     */
    public static function setChangelog(string $changelog): void
    {
        self::$changelog = $changelog;
    }
}

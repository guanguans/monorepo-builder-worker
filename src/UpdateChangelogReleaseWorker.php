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

use Guanguans\MonorepoBuilderWorker\Contract\ReleaseWorkerInterface;
use MonorepoBuilderPrefix202304\Nette\Utils\DateTime;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class UpdateChangelogReleaseWorker implements ReleaseWorkerInterface
{
    /** @var ProcessRunner */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function work(Version $version): void
    {
        $this->processRunner->run(sprintf(
            './vendor/bin/conventional-changelog --ver=%s --ansi -v',
            $version->getOriginalString()
        ));
        $this->processRunner->run('git add CHANGELOG.md && git checkout -- *.json');
    }

    public function getDescription(Version $version): string
    {
        return sprintf(
            'Update `CHANGELOG.md` to "%s -%s"',
            $version->getOriginalString(),
            (new DateTime())->format('Y-m-d')
        );
    }
}

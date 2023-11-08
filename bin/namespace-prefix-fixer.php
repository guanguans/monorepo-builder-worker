<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

$loaded = false;

foreach ([__DIR__.'/../../../autoload.php', __DIR__.'/../vendor/autoload.php'] as $file) {
    if (file_exists($file)) {
        require $file;
        $loaded = true;

        break;
    }
}

if (! $loaded) {
    exit(
        'You need to set up the project dependencies using the following commands:'.PHP_EOL.
        'wget https://getcomposer.org/composer.phar'.PHP_EOL.
        'php composer.phar install'.PHP_EOL
    );
}

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

/**
 * ```
 * php ./bin/namespace-prefix-fixer
 * ```
 *
 * @noinspection PhpUnhandledExceptionInspection
 */
(new SingleCommandApplication())
    ->setName('Namespace Prefix Fixer')
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        $yearMonth = date('Ym');
        while ($yearMonth >= 202310 && ! class_exists(sprintf('MonorepoBuilderPrefix%s\Symfony\Component\Console\Style\SymfonyStyle', $yearMonth))) {
            $yearMonth = date('Ym', strtotime('-1 month', strtotime("{$yearMonth}10")));
        }

        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->info("The correct namespace prefix is [MonorepoBuilderPrefix$yearMonth].");

        /** @var \Symfony\Component\Finder\SplFileInfo $splFileInfo */
        foreach (
            Finder::create()
                ->in([__DIR__.'/../src', __DIR__.'/../tests'])
                ->name('*.php')
                ->ignoreDotFiles(true)
                ->ignoreVCS(true)
            as $splFileInfo
        ) {
            $replacedContents = preg_replace('/MonorepoBuilderPrefix\d{4}\d{2}/', "MonorepoBuilderPrefix$yearMonth", $splFileInfo->getContents());
            if ($replacedContents !== $splFileInfo->getContents()) {
                $symfonyStyle->info("The file's [{$splFileInfo->getRelativePathname()}] namespace prefix is being fixed...");
            }

            file_put_contents($splFileInfo->getRealPath(), $replacedContents);
        }

        $symfonyStyle->success("The all files's namespace prefix has been fixed.");

        return Command::SUCCESS;
    })
    ->run();

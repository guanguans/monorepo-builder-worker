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

(static function (): void {
    $yearMonth = date('Ym');
    while ($yearMonth >= 202310 && ! class_exists(sprintf('MonorepoBuilderPrefix%s\Symfony\Component\Console\Style\SymfonyStyle', $yearMonth))) {
        $yearMonth = date('Ym', strtotime('-1 month', strtotime("{$yearMonth}10")));
    }

    echo PHP_EOL,"The correct namespace prefix is [MonorepoBuilderPrefix$yearMonth].", PHP_EOL;

    foreach (array_map('realpath', glob(__DIR__.'/../{src,tests}{/,/*/,/*/*/,/*/*/*/}*.php', GLOB_BRACE)) as $file) {
        $contents = file_get_contents($file);

        $replacedContents = preg_replace('/MonorepoBuilderPrefix\d{4}\d{2}/', "MonorepoBuilderPrefix$yearMonth", $contents);

        if ($replacedContents !== $contents) {
            echo "The file's [{$file}] namespace prefix is being fixed...", PHP_EOL;
        }

        file_put_contents($file, $replacedContents);
    }

    echo "The all files's namespace prefix has been fixed.", PHP_EOL;
})();

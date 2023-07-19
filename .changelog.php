<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/monorepo-builder-worker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'root' => getcwd(),
    'path' => 'CHANGELOG.md',
    'headerTitle' => 'Changelog',
    'headerDescription' => 'All notable changes to this project will be documented in this file.',
    'sortBy' => 'subject',
    'preset' => [
        // Breaking changes section
        'breaking_changes' => ['label' => '⚠ BREAKING CHANGES', 'description' => 'Code changes that potentially causes other components to fail'],
        // Types section
        'feat' => ['label' => 'Features', 'description' => 'New features'],
        'perf' => ['label' => 'Performance Improvements', 'description' => 'Code changes that improves performance'],
        'fix' => ['label' => 'Bug Fixes', 'description' => 'Bugs and issues resolution'],
        'refactor' => ['label' => 'Code Refactoring', 'description' => 'A code change that neither fixes a bug nor adds a feature'],
        'style' => ['label' => 'Styles', 'description' => 'Changes that do not affect the meaning of the code'],
        'test' => ['label' => 'Tests', 'description' => 'Adding missing tests or correcting existing tests'],
        'build' => ['label' => 'Builds', 'description' => 'Changes that affect the build system or external dependencies '],
        'ci' => ['label' => 'Continuous Integrations', 'description' => 'Changes to CI configuration files and scripts'],
        'docs' => ['label' => 'Documentation', 'description' => 'Documentation changes'],
        'chore' => ['label' => 'Chores', 'description' => "Other changes that don't modify the source code or test files"],
        'revert' => ['label' => 'Reverts', 'description' => 'Reverts a previous commit'],
    ],
    'types' => [],
    'packageBump' => true,
    'packageBumps' => [],
    'packageLockCommit' => true,
    'ignoreTypes' => ['build', 'chore', 'ci', 'docs', 'perf', 'refactor', 'revert', 'style', 'test'],
    'ignorePatterns' => ['/^chore\(release\):/i'],
    'tagPrefix' => 'v',
    'tagSuffix' => '',
    'skipBump' => false,
    'skipTag' => false,
    'skipVerify' => false,
    'disableLinks' => false,
    'hiddenHash' => false,
    'hiddenMentions' => false,
    'hiddenReferences' => false,
    'prettyScope' => true,
    'urlProtocol' => 'https',
    'dateFormat' => 'Y-m-d',
    'changelogVersionFormat' => '## {{version}} ({{date}})',
    'commitUrlFormat' => '{{host}}/{{owner}}/{{repository}}/commit/{{hash}}',
    'compareUrlFormat' => '{{host}}/{{owner}}/{{repository}}/compare/{{previousTag}}...{{currentTag}}',
    'issueUrlFormat' => '{{host}}/{{owner}}/{{repository}}/issues/{{id}}',
    'userUrlFormat' => '{{host}}/{{user}}',
    'releaseCommitMessageFormat' => 'chore(release): {{currentTag}}',
    'hiddenVersionSeparator' => false,
    'preRun' => null,
    'postRun' => null,
    'merged' => false,
];
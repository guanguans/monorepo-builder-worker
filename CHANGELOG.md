<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="1.1.4"></a>
## [1.1.4] - 2023-07-21
### Chore
- **composer:** update pest and pest-coverage scripts
- **release:** 1.1.3

### Feat
- **deps:** Add nunomaduro/mock-final-classes package

### Fix
- **Changelog:** Fix substring position in GoUpdateChangelogReleaseWorker

### Refactor
- **concern:** Update access modifiers in ConcreteFactory


<a name="1.1.3"></a>
## [1.1.3] - 2023-07-21
### Chore
- **ReleaseWorker:** optimize changelog generation
- **release:** 1.1.2

### Docs
- **changelog:** add link to git-chglog

### Feat
- **Contract:** Add ChangelogInterface

### Refactor
- **CreateGithubReleaseWorker:** improve changelog handling


<a name="1.1.2"></a>
## [1.1.2] - 2023-07-21
### Chore
- **release:** Update Go changelog


<a name="1.1.1"></a>
## [1.1.1] - 2023-07-21
### Chore
- **release:** 1.1.0

### Feat
- **monorepo-builder:** add GoUpdateChangelogReleaseWorker
- **support:** add checkFromCallback method

### Fix
- **DisallowedEmptyRuleFixerRector:** enable disallowed empty rule fixer for all files


<a name="1.1.0"></a>
## [1.1.0] - 2023-07-21
### Chore
- **release:** 1.0.4

### Feat
- **GoUpdateChangelogReleaseWorker:** add getChangelog method
- **ReleaseWorker:** Add GoUpdateChangelogReleaseWorker class
- **chglog:** add CHANGELOG template file

### Fix
- **ReleaseWorker:** handle empty changelog in GoUpdateChangelogReleaseWorker
- **changelog:** remove Unreleased link

### Refactor
- **CreateGithubReleaseWorker:** remove unnecessary git command
- **monorepo-builder:** rename UpdateChangelogReleaseWorker to PhpUpdateChangelogReleaseWorker


<a name="1.0.4"></a>
## [1.0.4] - 2023-07-20
### Chore
- **Concern:** remove EnvironmentChecker trait
- **release:** 1.0.3

### Feat
- **UpdateChangelogReleaseWorker:** add Assert dependency

### Refactor
- **CreateGithubReleaseWorker:** update getChangelog method


<a name="1.0.3"></a>
## [1.0.3] - 2023-07-20
### Chore
- **Concern:** add createSymfonyStyle method
- **release:** 1.0.2

### Refactor
- **Concern:** Rename ProcessRunnerFactory to ConcreteFactory
- **support:** use ConcreteFactory trait in EnvironmentChecker


<a name="1.0.2"></a>
## [1.0.2] - 2023-07-20
### Chore
- **release:** 1.0.1

### Feat
- **UpdateChangelogReleaseWorker:** add getChangelogDiff method

### Fix
- **release:** Fix issue with changelog generation


<a name="1.0.1"></a>
## [1.0.1] - 2023-07-20
### Chore
- **release:** 1.0.1
- **release:** 1.0.0

### Feat
- **UpdateChangelogReleaseWorker:** Add method getPreviousTag

### Fix
- **CreateGithubReleaseWorker:** handle empty commitId
- **release:** Fix line filtering in CreateGithubReleaseWorker
- **support:** Fix environment checking logic


<a name="1.0.0"></a>
## [1.0.0] - 2023-07-19
### Chore
- **release:** add git check command
- **release:** 0.6.0

### Feat
- **workflows:** add PHP 8.2 to matrix in tests.yml

### Fix
- **CreateGithubReleaseWorker:** handle missing changelog gracefully

### Style
- **EnvironmentChecker:** Improve code readability in check method


<a name="0.6.0"></a>
## [0.6.0] - 2023-07-19
### Chore
- **commit:** improve commit message examples

### Docs
- **changelog:** update CHANGELOG.md to 0.5.0

### Feat
- **CreateGithubReleaseWorker:** add 'gh release list' command

### Fix
- **UpdateChangelogReleaseWorker:** modify commit message format
- **github:** Fix description for github release


<a name="0.5.0"></a>
## [0.5.0] - 2023-07-19
### Chore
- **ReleaseWorker:** Add EnvironmentChecker and commands property

### Docs
- **changelog:** update CHANGELOG.md to 0.4.0
- **create-github-release:** Update description format

### Feat
- **Concern:** Add ProcessRunnerFactory trait
- **Contract:** add ProcessRunnerFactoryInterface
- **CreateGithubReleaseWorker:** add 'gh auth status' to check commands
- **EnvironmentChecker:** add check method
- **changelog:** Add new changelog configuration file

### Refactor
- **ProcessRunnerFactory:** optimize process runner creation
- **ReleaseWorker:** update property name in ReleaseWorker
- **ReleaseWorker:** update createProcessRunner method
- **src:** update ReleaseWorker.php


<a name="0.4.0"></a>
## [0.4.0] - 2023-07-18
### Docs
- **changelog:** update CHANGELOG.md to 0.3.0

### Feat
- **monorepo-builder:** Implement checkEnvironment() in CreateGithubReleaseWorker
- **utils:** Add Utils class

### Refactor
- **datasets:** rename Movies.php to Datasets/Movies.php
- **monorepo-builder:** rename CheckEnvironmentInterface to CheckReleaseWorkerEnvironmentInterface
- **worker:** Rename ReleaseWorkerInterface to CheckEnvironmentInterface


<a name="0.3.0"></a>
## [0.3.0] - 2023-07-18
### Chore
- fix formatting in UpdateChangelogReleaseWorker.php
- **composer:** update composer.json
- **composer.json:** update package description
- **git:** update phpstan.neon

### Docs
- **changelog:** update CHANGELOG.md
- **readme:** update README.md

### Refactor
- **psalm:** Clean up psalm-baseline.xml


<a name="0.2.0"></a>
## [0.2.0] - 2023-07-18
### Docs
- **changelog:** remove version 0.2.0
- **changelog:** update CHANGELOG.md

### Fix
- **release:** fix git checkout for *.json files
- **worker:** fix git checkout command

### Refactor
- **release:** Update release worker sequence


<a name="0.1.2"></a>
## [0.1.2] - 2023-07-18
### Chore
- **workflows:** update PHP version in php-cs-fixer.yml


<a name="0.1.1"></a>
## [0.1.1] - 2023-07-18

<a name="v0.1.0"></a>
## v0.1.0 - 2023-07-18
### Chore
- **CreateGithubReleaseWorker:** add command to create GitHub release
- **composer:** Update branch-alias for dev-main
- **composer:** remove version field from composer.json

### Feat
- **README:** update project description
- **create-github-release-worker:** add CreateGithubReleaseWorker class
- **create-github-release-worker:** add CreateGithubReleaseWorker class
- **deps:** add pyrech/composer-changelogs package
- **monorepo-builder:** add CreateGithubReleaseWorker class
- **worker:** Add CreateGithubReleaseWorker class

### Fix
- **composer.json:** Update dependencies version
- **worker:** update version parameter in UpdateChangelogReleaseWorker

### Refactor
- **CreateGithubReleaseWorker:** change method of version retrieval
- **release:** improve code readability


[Unreleased]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.4...HEAD
[1.1.4]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/guanguans/monorepo-builder-worker/compare/1.0.4...1.1.0
[1.0.4]: https://github.com/guanguans/monorepo-builder-worker/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/guanguans/monorepo-builder-worker/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/guanguans/monorepo-builder-worker/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/guanguans/monorepo-builder-worker/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/guanguans/monorepo-builder-worker/compare/0.6.0...1.0.0
[0.6.0]: https://github.com/guanguans/monorepo-builder-worker/compare/0.5.0...0.6.0
[0.5.0]: https://github.com/guanguans/monorepo-builder-worker/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/guanguans/monorepo-builder-worker/compare/0.3.0...0.4.0
[0.3.0]: https://github.com/guanguans/monorepo-builder-worker/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/guanguans/monorepo-builder-worker/compare/0.1.2...0.2.0
[0.1.2]: https://github.com/guanguans/monorepo-builder-worker/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...0.1.1

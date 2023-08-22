<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="1.2.2"></a>
## [1.2.2] - 2023-08-22
### Fix
- **CreateGithubReleaseWorker:** add title and verify-tag options

### Pull Requests
- Merge pull request [#12](https://github.com/guanguans/monorepo-builder-worker/issues/12) from guanguans/dependabot/composer/rector/rector-tw-0.17or-tw-0.18
- Merge pull request [#11](https://github.com/guanguans/monorepo-builder-worker/issues/11) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.52.1
- Merge pull request [#10](https://github.com/guanguans/monorepo-builder-worker/issues/10) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.50.0
- Merge pull request [#9](https://github.com/guanguans/monorepo-builder-worker/issues/9) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.48.0
- Merge pull request [#8](https://github.com/guanguans/monorepo-builder-worker/issues/8) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.47.0


<a name="1.2.1"></a>
## [1.2.1] - 2023-08-08
### Refactor
- **changelog:** update class references
- **concerns:** rename ConcreteFactory.php to ConcreteFactory.php


<a name="1.2.0"></a>
## [1.2.0] - 2023-08-08
### Fix
- **src:** Update Symfony components version

### Pull Requests
- Merge pull request [#7](https://github.com/guanguans/monorepo-builder-worker/issues/7) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.46.3
- Merge pull request [#6](https://github.com/guanguans/monorepo-builder-worker/issues/6) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.46.2
- Merge pull request [#5](https://github.com/guanguans/monorepo-builder-worker/issues/5) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.46.1
- Merge pull request [#4](https://github.com/guanguans/monorepo-builder-worker/issues/4) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.45.3
- Merge pull request [#3](https://github.com/guanguans/monorepo-builder-worker/issues/3) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.45.2
- Merge pull request [#2](https://github.com/guanguans/monorepo-builder-worker/issues/2) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.45.1
- Merge pull request [#1](https://github.com/guanguans/monorepo-builder-worker/issues/1) from guanguans/dependabot/github_actions/trufflesecurity/trufflehog-3.45.0


<a name="1.1.11"></a>
## [1.1.11] - 2023-07-24
### Feat
- **CreateGithubReleaseWorkerTest:** Update changelog content

### Fix
- **Changelog:** handle missing changelog sections
- **NodeUpdateChangelogReleaseWorker:** handle missing changelog sections
- **PhpUpdateChangelogReleaseWorker:** fix condition for valid lines


<a name="1.1.10"></a>
## [1.1.10] - 2023-07-24
### Refactor
- **Changelog:** update line filtering logic


<a name="1.1.9"></a>
## [1.1.9] - 2023-07-23
### Feat
- **deps:** add symfony/polyfill-php80

### Refactor
- **composer.json:** update package name and URLs


<a name="1.1.8"></a>
## [1.1.8] - 2023-07-22
### CI
- **chglog:** configure CI pipeline for changelog generation

### Feat
- **worker:** add NodeUpdateChangelogReleaseWorker

### Fix
- **changelog:** remove redundant cast in PhpUpdateChangelogReleaseWorker
- **contract:** Remove unnecessary exception

### Refactor
- **concern:** update ConcreteFactory trait


<a name="1.1.7"></a>
## [1.1.7] - 2023-07-22
### Feat
- **NodeUpdateChangelogReleaseWorkerTest:** create new test file

### Fix
- **config:** Add missing newline in config.yml


<a name="1.1.6"></a>
## [1.1.6] - 2023-07-22
### Feat
- **NodeUpdateChangelogReleaseWorker:** add NodeUpdateChangelogReleaseWorker class

### Refactor
- **EnvironmentChecker:** improve check method


<a name="1.1.5"></a>
## [1.1.5] - 2023-07-21
### Fix
- **Changelog:** fix regex pattern for replacing unreleased link


<a name="1.1.4"></a>
## [1.1.4] - 2023-07-21
### Feat
- **deps:** Add nunomaduro/mock-final-classes package

### Fix
- **Changelog:** Fix substring position in GoUpdateChangelogReleaseWorker

### Refactor
- **concern:** Update access modifiers in ConcreteFactory


<a name="1.1.3"></a>
## [1.1.3] - 2023-07-21
### Docs
- **changelog:** add link to git-chglog

### Feat
- **Contract:** Add ChangelogInterface

### Refactor
- **CreateGithubReleaseWorker:** improve changelog handling


<a name="1.1.2"></a>
## [1.1.2] - 2023-07-21

<a name="1.1.1"></a>
## [1.1.1] - 2023-07-21
### Feat
- **monorepo-builder:** add GoUpdateChangelogReleaseWorker
- **support:** add checkFromCallback method

### Fix
- **DisallowedEmptyRuleFixerRector:** enable disallowed empty rule fixer for all files


<a name="1.1.0"></a>
## [1.1.0] - 2023-07-21
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
### Feat
- **UpdateChangelogReleaseWorker:** add Assert dependency

### Refactor
- **CreateGithubReleaseWorker:** update getChangelog method


<a name="1.0.3"></a>
## [1.0.3] - 2023-07-20
### Refactor
- **Concern:** Rename ProcessRunnerFactory to ConcreteFactory
- **support:** use ConcreteFactory trait in EnvironmentChecker


<a name="1.0.2"></a>
## [1.0.2] - 2023-07-20
### Feat
- **UpdateChangelogReleaseWorker:** add getChangelogDiff method

### Fix
- **release:** Fix issue with changelog generation


<a name="1.0.1"></a>
## [1.0.1] - 2023-07-20
### Feat
- **UpdateChangelogReleaseWorker:** Add method getPreviousTag

### Fix
- **CreateGithubReleaseWorker:** handle empty commitId
- **release:** Fix line filtering in CreateGithubReleaseWorker
- **support:** Fix environment checking logic


<a name="1.0.0"></a>
## [1.0.0] - 2023-07-19
### Feat
- **workflows:** add PHP 8.2 to matrix in tests.yml

### Fix
- **CreateGithubReleaseWorker:** handle missing changelog gracefully


<a name="0.6.0"></a>
## [0.6.0] - 2023-07-19
### Docs
- **changelog:** update CHANGELOG.md to 0.5.0

### Feat
- **CreateGithubReleaseWorker:** add 'gh release list' command

### Fix
- **UpdateChangelogReleaseWorker:** modify commit message format
- **github:** Fix description for github release


<a name="0.5.0"></a>
## [0.5.0] - 2023-07-19
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

<a name="0.1.1"></a>
## [0.1.1] - 2023-07-18

<a name="v0.1.0"></a>
## v0.1.0 - 2023-07-18
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


[Unreleased]: https://github.com/guanguans/monorepo-builder-worker/compare/1.2.2...HEAD
[1.2.2]: https://github.com/guanguans/monorepo-builder-worker/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/guanguans/monorepo-builder-worker/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.11...1.2.0
[1.1.11]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.10...1.1.11
[1.1.10]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.9...1.1.10
[1.1.9]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.8...1.1.9
[1.1.8]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.7...1.1.8
[1.1.7]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.6...1.1.7
[1.1.6]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.5...1.1.6
[1.1.5]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.4...1.1.5
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

<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

## [1.0.4](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.4) (2023-07-20)

### Features


##### Update Changelog Release Worker

* Add Assert dependency ([4f9fad](https://github.com/guanguans/monorepo-builder-worker/commit/4f9fad68c5f912202a60ff3c1fe2522231c9b1e6))


---

## [1.0.3](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.3) (2023-07-20)


---

## [1.0.2](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.2) (2023-07-20)

### Features


##### Update Changelog Release Worker

* Add getChangelogDiff method ([b47ac6](https://github.com/guanguans/monorepo-builder-worker/commit/b47ac6bc442904c47ec1127c1edd257b9b66e1cf))

### Bug Fixes


##### Release

* Fix issue with changelog generation ([4bac2f](https://github.com/guanguans/monorepo-builder-worker/commit/4bac2f36b9f109c3683dfe73e6945efe4378e00e))


---

## [1.0.1](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.1) (2023-07-20)


---

## [1.0.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.0) (2023-07-20)

### ⚠ BREAKING CHANGES


##### Create Github Release Worker

* Implement getChangelog method ([61a378](https://github.com/guanguans/monorepo-builder-worker/commit/61a3781ed542d6452d33e930df70d94e77fd06bb))

### Features


##### Workflows

* Add PHP 8.2 to matrix in tests.yml ([2b6837](https://github.com/guanguans/monorepo-builder-worker/commit/2b68377825c238a94d749055d5c9bcaf58fc4687))

### Bug Fixes


##### Create Github Release Worker

* Handle missing changelog gracefully ([052590](https://github.com/guanguans/monorepo-builder-worker/commit/05259039397d8df0acdc92e7f0ad10cdfd603b04))


---

## [0.6.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.6.0) (2023-07-20)

### ⚠ BREAKING CHANGES


##### Concern

* Add ExecutableFinderFactory trait ([19d01f](https://github.com/guanguans/monorepo-builder-worker/commit/19d01fa1b6293ec0c352a612f0b62d98bb0d7bd7))

### Features


##### Create Github Release Worker

* Add 'gh release list' command ([21c769](https://github.com/guanguans/monorepo-builder-worker/commit/21c76940197feb22405412bdd6969644b219f5ca))

### Bug Fixes


##### Github

* Fix description for github release ([068a5c](https://github.com/guanguans/monorepo-builder-worker/commit/068a5c4f04e2324e886e0abbbae1b953899be291))

##### Update Changelog Release Worker

* Modify commit message format ([8438f0](https://github.com/guanguans/monorepo-builder-worker/commit/8438f08d0e909601175464ba61885f148c8e26e4))


---

## [0.5.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.5.0) (2023-07-20)

### Features


##### Changelog

* Add new changelog configuration file ([cd5650](https://github.com/guanguans/monorepo-builder-worker/commit/cd56507b1d7ccc96b671fe5b196c9156ca71906b))

##### Concern

* Add ProcessRunnerFactory trait ([424613](https://github.com/guanguans/monorepo-builder-worker/commit/424613a2c2ed3567bd4a375171f8f21cce9e0c35))

##### Contract

* Add ProcessRunnerFactoryInterface ([50b293](https://github.com/guanguans/monorepo-builder-worker/commit/50b293318ac45feb4430275c80a1ee13a8bd32f3))

##### Create Github Release Worker

* Add 'gh auth status' to check commands ([6cc433](https://github.com/guanguans/monorepo-builder-worker/commit/6cc433a6a454a13005836bbf6c2f1eeb9694ebec))

##### Environment Checker

* Add check method ([d5c394](https://github.com/guanguans/monorepo-builder-worker/commit/d5c394697835e82d5c79705ce4d843941a0e1b5c))


---

## [0.4.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.4.0) (2023-07-20)

### Features


##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))


---

## [0.3.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.3.0) (2023-07-20)


---

## [0.2.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.2.0) (2023-07-20)

### Bug Fixes


##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.1.2](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.1.2) (2023-07-20)


---

## [0.1.1](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.1.1) (2023-07-20)


---

## [0.1.0](https://github.com/guanguans/monorepo-builder-worker/compare/c41a24987f4526791fa7cf8c3bde3343685e98cf...v0.1.0) (2023-07-20)

### Features


##### Create-github-release-worker

* Add CreateGithubReleaseWorker class ([21d624](https://github.com/guanguans/monorepo-builder-worker/commit/21d6242680ff3e3828b9162bcc14b740403387f5), [e41fac](https://github.com/guanguans/monorepo-builder-worker/commit/e41facf1d6519c9765a20a8e6eb6e967f7c74e65))

##### Deps

* Add pyrech/composer-changelogs package ([f3c3ad](https://github.com/guanguans/monorepo-builder-worker/commit/f3c3ad2adff896551ef611376e0caea1cbe3d7b0))

##### Monorepo-builder

* Add CreateGithubReleaseWorker class ([d8cd73](https://github.com/guanguans/monorepo-builder-worker/commit/d8cd737f5c2de393f0843e9be882062a00159b0a))

##### README

* Update project description ([00496a](https://github.com/guanguans/monorepo-builder-worker/commit/00496a5a677937f067bc5997617734d1da96a267))

##### Worker

* Add CreateGithubReleaseWorker class ([bf4b4a](https://github.com/guanguans/monorepo-builder-worker/commit/bf4b4a33a3473f25641a639160afb537885cecca))

### Bug Fixes


##### Composer

* Update dependencies version ([bcefcb](https://github.com/guanguans/monorepo-builder-worker/commit/bcefcb04b93019db3ff09326ab47679afc2319b9))

##### Worker

* Update version parameter in UpdateChangelogReleaseWorker ([8ce0d5](https://github.com/guanguans/monorepo-builder-worker/commit/8ce0d54c79833f514cf6a267eaebf98b2d794d09))


---

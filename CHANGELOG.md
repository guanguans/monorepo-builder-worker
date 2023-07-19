<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

## [1.0.1](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.1) (2023-07-19)

### ⚠ BREAKING CHANGES


##### Concern

* Add ExecutableFinderFactory trait ([19d01f](https://github.com/guanguans/monorepo-builder-worker/commit/19d01fa1b6293ec0c352a612f0b62d98bb0d7bd7))

##### Create Github Release Worker

* Implement getChangelog method ([61a378](https://github.com/guanguans/monorepo-builder-worker/commit/61a3781ed542d6452d33e930df70d94e77fd06bb))

### Features


##### Changelog

* Add new changelog configuration file ([cd5650](https://github.com/guanguans/monorepo-builder-worker/commit/cd56507b1d7ccc96b671fe5b196c9156ca71906b))

##### Concern

* Add ProcessRunnerFactory trait ([424613](https://github.com/guanguans/monorepo-builder-worker/commit/424613a2c2ed3567bd4a375171f8f21cce9e0c35))

##### Contract

* Add ProcessRunnerFactoryInterface ([50b293](https://github.com/guanguans/monorepo-builder-worker/commit/50b293318ac45feb4430275c80a1ee13a8bd32f3))

##### Create Github Release Worker

* Add 'gh auth status' to check commands ([6cc433](https://github.com/guanguans/monorepo-builder-worker/commit/6cc433a6a454a13005836bbf6c2f1eeb9694ebec))
* Add 'gh release list' command ([21c769](https://github.com/guanguans/monorepo-builder-worker/commit/21c76940197feb22405412bdd6969644b219f5ca))

##### Environment Checker

* Add check method ([d5c394](https://github.com/guanguans/monorepo-builder-worker/commit/d5c394697835e82d5c79705ce4d843941a0e1b5c))

##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))

##### Workflows

* Add PHP 8.2 to matrix in tests.yml ([2b6837](https://github.com/guanguans/monorepo-builder-worker/commit/2b68377825c238a94d749055d5c9bcaf58fc4687))

### Bug Fixes


##### Create Github Release Worker

* Handle empty commitId ([6574f7](https://github.com/guanguans/monorepo-builder-worker/commit/6574f7d191a58f7897b2728d85da47fe7ee43a95))
* Handle missing changelog gracefully ([052590](https://github.com/guanguans/monorepo-builder-worker/commit/05259039397d8df0acdc92e7f0ad10cdfd603b04))

##### Github

* Fix description for github release ([068a5c](https://github.com/guanguans/monorepo-builder-worker/commit/068a5c4f04e2324e886e0abbbae1b953899be291))

##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))
* Fix line filtering in CreateGithubReleaseWorker ([598a33](https://github.com/guanguans/monorepo-builder-worker/commit/598a333e00b2c6ab1ee60e6ddf3ec914258407ee))

##### Support

* Fix environment checking logic ([8150d9](https://github.com/guanguans/monorepo-builder-worker/commit/8150d929fbc1906d17488ab053279aaa7eed4d88))

##### Update Changelog Release Worker

* Modify commit message format ([8438f0](https://github.com/guanguans/monorepo-builder-worker/commit/8438f08d0e909601175464ba61885f148c8e26e4))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [1.0.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.0) (2023-07-19)

### ⚠ BREAKING CHANGES


##### Concern

* Add ExecutableFinderFactory trait ([19d01f](https://github.com/guanguans/monorepo-builder-worker/commit/19d01fa1b6293ec0c352a612f0b62d98bb0d7bd7))

##### Create Github Release Worker

* Implement getChangelog method ([61a378](https://github.com/guanguans/monorepo-builder-worker/commit/61a3781ed542d6452d33e930df70d94e77fd06bb))

### Features


##### Changelog

* Add new changelog configuration file ([cd5650](https://github.com/guanguans/monorepo-builder-worker/commit/cd56507b1d7ccc96b671fe5b196c9156ca71906b))

##### Concern

* Add ProcessRunnerFactory trait ([424613](https://github.com/guanguans/monorepo-builder-worker/commit/424613a2c2ed3567bd4a375171f8f21cce9e0c35))

##### Contract

* Add ProcessRunnerFactoryInterface ([50b293](https://github.com/guanguans/monorepo-builder-worker/commit/50b293318ac45feb4430275c80a1ee13a8bd32f3))

##### Create Github Release Worker

* Add 'gh auth status' to check commands ([6cc433](https://github.com/guanguans/monorepo-builder-worker/commit/6cc433a6a454a13005836bbf6c2f1eeb9694ebec))
* Add 'gh release list' command ([21c769](https://github.com/guanguans/monorepo-builder-worker/commit/21c76940197feb22405412bdd6969644b219f5ca))

##### Environment Checker

* Add check method ([d5c394](https://github.com/guanguans/monorepo-builder-worker/commit/d5c394697835e82d5c79705ce4d843941a0e1b5c))

##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))

##### Workflows

* Add PHP 8.2 to matrix in tests.yml ([2b6837](https://github.com/guanguans/monorepo-builder-worker/commit/2b68377825c238a94d749055d5c9bcaf58fc4687))

### Bug Fixes


##### Create Github Release Worker

* Handle missing changelog gracefully ([052590](https://github.com/guanguans/monorepo-builder-worker/commit/05259039397d8df0acdc92e7f0ad10cdfd603b04))

##### Github

* Fix description for github release ([068a5c](https://github.com/guanguans/monorepo-builder-worker/commit/068a5c4f04e2324e886e0abbbae1b953899be291))

##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Update Changelog Release Worker

* Modify commit message format ([8438f0](https://github.com/guanguans/monorepo-builder-worker/commit/8438f08d0e909601175464ba61885f148c8e26e4))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.6.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.6.0) (2023-07-19)

### ⚠ BREAKING CHANGES


##### Concern

* Add ExecutableFinderFactory trait ([19d01f](https://github.com/guanguans/monorepo-builder-worker/commit/19d01fa1b6293ec0c352a612f0b62d98bb0d7bd7))

### Features


##### Changelog

* Add new changelog configuration file ([cd5650](https://github.com/guanguans/monorepo-builder-worker/commit/cd56507b1d7ccc96b671fe5b196c9156ca71906b))

##### Concern

* Add ProcessRunnerFactory trait ([424613](https://github.com/guanguans/monorepo-builder-worker/commit/424613a2c2ed3567bd4a375171f8f21cce9e0c35))

##### Contract

* Add ProcessRunnerFactoryInterface ([50b293](https://github.com/guanguans/monorepo-builder-worker/commit/50b293318ac45feb4430275c80a1ee13a8bd32f3))

##### Create Github Release Worker

* Add 'gh auth status' to check commands ([6cc433](https://github.com/guanguans/monorepo-builder-worker/commit/6cc433a6a454a13005836bbf6c2f1eeb9694ebec))
* Add 'gh release list' command ([21c769](https://github.com/guanguans/monorepo-builder-worker/commit/21c76940197feb22405412bdd6969644b219f5ca))

##### Environment Checker

* Add check method ([d5c394](https://github.com/guanguans/monorepo-builder-worker/commit/d5c394697835e82d5c79705ce4d843941a0e1b5c))

##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))

### Bug Fixes


##### Github

* Fix description for github release ([068a5c](https://github.com/guanguans/monorepo-builder-worker/commit/068a5c4f04e2324e886e0abbbae1b953899be291))

##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Update Changelog Release Worker

* Modify commit message format ([8438f0](https://github.com/guanguans/monorepo-builder-worker/commit/8438f08d0e909601175464ba61885f148c8e26e4))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.5.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.5.0) (2023-07-19)

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

##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))

### Bug Fixes


##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))

## [0.5.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.5.0) (2023-07-19)

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

##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))

### Bug Fixes


##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.4.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.4.0) (2023-07-18)

### Features


##### Monorepo-builder

* Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))

##### Utils

* Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))

### Bug Fixes


##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.3.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.3.0) (2023-07-18)

### Bug Fixes


##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.2.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.2.0) (2023-07-18)

### Bug Fixes


##### Release

* Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))

##### Worker

* Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))


---

## [0.1.2](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.1.2) (2023-07-18)


---

## [0.1.1](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v0.1.1) (2023-07-18)


---

## [0.1.0](https://github.com/guanguans/monorepo-builder-worker/compare/0.0.0...v0.1.0) (2023-07-18)


---


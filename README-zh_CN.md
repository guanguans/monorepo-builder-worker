# monorepo-builder-worker

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> List of release worker collections for [symplify/monorepo-builder](https://github.com/symplify/monorepo-builder).

[![tests](https://github.com/guanguans/monorepo-builder-worker/workflows/tests/badge.svg)](https://github.com/guanguans/monorepo-builder-worker/actions)
[![check & fix styling](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/monorepo-builder-worker/actions)
[![psalm](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/psalm.yml/badge.svg)](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/psalm.yml)
[![rector](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/rector.yml/badge.svg)](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/rector.yml)
[![codecov](https://codecov.io/gh/guanguans/monorepo-builder-worker/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/monorepo-builder-worker)
[![Latest Stable Version](https://poser.pugx.org/guanguans/monorepo-builder-worker/v)](https://packagist.org/packages/guanguans/monorepo-builder-worker)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/monorepo-builder-worker)
![GitHub repo size](https://img.shields.io/github/repo-size/guanguans/monorepo-builder-worker)
[![Total Downloads](https://poser.pugx.org/guanguans/monorepo-builder-worker/downloads)](https://packagist.org/packages/guanguans/monorepo-builder-worker)
[![License](https://poser.pugx.org/guanguans/monorepo-builder-worker/license)](https://packagist.org/packages/guanguans/monorepo-builder-worker)

## 环境要求

* PHP >= 7.3

## 安装

```bash
composer require guanguans/monorepo-builder-worker --prefer-dist --dev -v
```

## 使用

参考 [monorepo-builder.php](./monorepo-builder.php)

```shell
╰─ ./vendor/bin/monorepo-builder release --ansi -v 'major'                                                                                                                          ─╯

 ! [NOTE] Running process: git rev-parse --is-inside-work-tree                                                          

 ! [NOTE] Running process: ./vendor/bin/conventional-changelog --help                                                   

 ! [NOTE] Running process: git rev-parse --is-inside-work-tree                                                          

 ! [NOTE] Running process: gh auth status                                                                               

 ! [NOTE] Running process: gh release list --limit 1                                                                    


 ! [NOTE] Running process: git tag -l --sort=committerdate                                                              

1/4) Add local tag "1.0.0"
==========================

class: Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker

 ! [NOTE] Running process: git add . && git commit -m "prepare release" && git push origin "main"                       

 ! [NOTE] Running process: git tag 1.0.0                                                                                

2/4) Push "1.0.0" tag to remote repository
==========================================

class: Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker

 ! [NOTE] Running process: git push --tags                                                                              

3/4) Update changelog "1.0.0 (2023-07-19)"
==========================================

class: Guanguans\MonorepoBuilderWorker\UpdateChangelogReleaseWorker

 ! [NOTE] Running process: ./vendor/bin/conventional-changelog --ver=1.0.0 --ansi -v                                    

 ! [NOTE] Running process: git checkout -- *.json && git add CHANGELOG.md && git commit -m "chore(release): 1.0.0"      
 !        --no-verify && git push                                                                                       

4/4) Create github release "1.0.0"
==================================

class: Guanguans\MonorepoBuilderWorker\CreateGithubReleaseWorker

 ! [NOTE] Running process: git log --oneline -5                                                                         

 ! [NOTE] Running process: git show 5d7ccb8                                                                             

 ! [NOTE] Running process: gh release create 1.0.0 --notes ## [1.0.0](https://github.com/guanguans/monorepo-builder-worker/compare/v0.1.0...v1.0.0) (2023-07-19)
 !                                                                                                                      
 !        ### ⚠ BREAKING CHANGES                                                                                        
 !                                                                                                                      
 !                                                                                                                      
 !        ##### Concern                                                                                                 
 !                                                                                                                      
 !        * Add ExecutableFinderFactory trait ([19d01f](https://github.com/guanguans/monorepo-builder-worker/commit/19d01fa1b6293ec0c352a612f0b62d98bb0d7bd7))
 !                                                                                                                      
 !        ##### Create Github Release Worker                                                                            
 !                                                                                                                      
 !        * Implement getChangelog method ([61a378](https://github.com/guanguans/monorepo-builder-worker/commit/61a3781ed542d6452d33e930df70d94e77fd06bb))
 !                                                                                                                      
 !        ### Features                                                                                                  
 !                                                                                                                      
 !                                                                                                                      
 !        ##### Changelog                                                                                               
 !                                                                                                                      
 !        * Add new changelog configuration file ([cd5650](https://github.com/guanguans/monorepo-builder-worker/commit/cd56507b1d7ccc96b671fe5b196c9156ca71906b))
 !                                                                                                                      
 !        ##### Concern                                                                                                 
 !                                                                                                                      
 !        * Add ProcessRunnerFactory trait ([424613](https://github.com/guanguans/monorepo-builder-worker/commit/424613a2c2ed3567bd4a375171f8f21cce9e0c35))
 !                                                                                                                      
 !        ##### Contract                                                                                                
 !                                                                                                                      
 !        * Add ProcessRunnerFactoryInterface ([50b293](https://github.com/guanguans/monorepo-builder-worker/commit/50b293318ac45feb4430275c80a1ee13a8bd32f3))
 !                                                                                                                      
 !        ##### Create Github Release Worker                                                                            
 !                                                                                                                      
 !        * Add 'gh auth status' to check commands ([6cc433](https://github.com/guanguans/monorepo-builder-worker/commit/6cc433a6a454a13005836bbf6c2f1eeb9694ebec))
 !        * Add 'gh release list' command ([21c769](https://github.com/guanguans/monorepo-builder-worker/commit/21c76940197feb22405412bdd6969644b219f5ca))
 !                                                                                                                      
 !        ##### Environment Checker                                                                                     
 !                                                                                                                      
 !        * Add check method ([d5c394](https://github.com/guanguans/monorepo-builder-worker/commit/d5c394697835e82d5c79705ce4d843941a0e1b5c))
 !                                                                                                                      
 !        ##### Monorepo-builder                                                                                        
 !                                                                                                                      
 !        * Implement checkEnvironment() in CreateGithubReleaseWorker ([149b33](https://github.com/guanguans/monorepo-builder-worker/commit/149b33cf76df37430e2746d747138247efb61ff0))
 !                                                                                                                      
 !        ##### Utils                                                                                                   
 !                                                                                                                      
 !        * Add Utils class ([bc04c8](https://github.com/guanguans/monorepo-builder-worker/commit/bc04c8c9f0b54c6920ffa1291d7a38a29a543070))
 !                                                                                                                      
 !        ##### Workflows                                                                                               
 !                                                                                                                      
 !        * Add PHP 8.2 to matrix in tests.yml ([2b6837](https://github.com/guanguans/monorepo-builder-worker/commit/2b68377825c238a94d749055d5c9bcaf58fc4687))
 !                                                                                                                      
 !        ### Bug Fixes                                                                                                 
 !                                                                                                                      
 !                                                                                                                      
 !        ##### Create Github Release Worker                                                                            
 !                                                                                                                      
 !        * Handle missing changelog gracefully ([052590](https://github.com/guanguans/monorepo-builder-worker/commit/05259039397d8df0acdc92e7f0ad10cdfd603b04))
 !                                                                                                                      
 !        ##### Github                                                                                                  
 !                                                                                                                      
 !        * Fix description for github release ([068a5c](https://github.com/guanguans/monorepo-builder-worker/commit/068a5c4f04e2324e886e0abbbae1b953899be291))
 !                                                                                                                      
 !        ##### Release                                                                                                 
 !                                                                                                                      
 !        * Fix git checkout for *.json files ([4cf64f](https://github.com/guanguans/monorepo-builder-worker/commit/4cf64f294475998b927010c5bc0942bf8e542909))
 !                                                                                                                      
 !        ##### Update Changelog Release Worker                                                                         
 !                                                                                                                      
 !        * Modify commit message format ([8438f0](https://github.com/guanguans/monorepo-builder-worker/commit/8438f08d0e909601175464ba61885f148c8e26e4))
 !                                                                                                                      
 !        ##### Worker                                                                                                  
 !                                                                                                                      
 !        * Fix git checkout command ([77559d](https://github.com/guanguans/monorepo-builder-worker/commit/77559dabb4357869c4a74553f091ec1c9e968192))
 !                                                                                                                      
 !                                                                                                                      
 !        ---                                                                                                           

                                                                                                                        
 [OK] Version "1.0.0" is now released!                                                                                  
                                                                                                                        
```

## 测试

```bash
composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证(MIT)。有关更多信息，请参见[协议文件](LICENSE)。

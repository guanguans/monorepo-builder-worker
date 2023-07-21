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
╰─ ./vendor/bin/monorepo-builder release patch --ansi -v                                                            ─╯

 ! [NOTE] Checking environment...                                                                                       


 ! [NOTE] Running process: git-chglog -v                                                                                

 ! [NOTE] Running process: gh auth status                                                                               

 ! [NOTE] Running process: gh release list --limit 1                                                                    

                                                                                                                        
 [OK] Environment checked.                                                                                              
                                                                                                                        


 ! [NOTE] Running process: git tag -l --sort=committerdate                                                              

1/4) Add local tag "1.1.3"
==========================

class: Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker

 ! [NOTE] Running process: git add . && git commit -m "prepare release" && git push origin "main"                       

 ! [NOTE] Running process: git tag 1.1.3                                                                                

2/4) Push "1.1.3" tag to remote repository
==========================================

class: Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker

 ! [NOTE] Running process: git push --tags                                                                              

3/4) Update changelog "1.1.3 (2023-07-21)"
==========================================

class: Guanguans\MonorepoBuilderWorker\GoUpdateChangelogReleaseWorker

 ! [NOTE] Running process: git-chglog --output CHANGELOG.md                                                             

 ! [NOTE] Running process: git add CHANGELOG.md && git commit -m "chore(release): 1.1.3" --no-verify && git push        

 ! [NOTE] Running process: git-chglog 1.1.3                                                                             

4/4) Create github release "1.1.3"
==================================

class: Guanguans\MonorepoBuilderWorker\CreateGithubReleaseWorker

 ! [NOTE] Running process: gh release create 1.1.3 --notes <a name="1.1.3"></a>                                         
 !        ## [1.1.3] - 2023-07-21                                                                                       
 !        ### Chore                                                                                                     
 !        - **ReleaseWorker:** optimize changelog generation                                                            
 !        - **release:** 1.1.2                                                                                          
 !                                                                                                                      
 !        ### Docs                                                                                                      
 !        - **changelog:** add link to git-chglog                                                                       
 !                                                                                                                      
 !        ### Feat                                                                                                      
 !        - **Contract:** Add ChangelogInterface                                                                        
 !                                                                                                                      
 !        ### Refactor                                                                                                  
 !        - **CreateGithubReleaseWorker:** improve changelog handling                                                   
 !                                                                                                                      
 !                                                                                                                      
 !        [1.1.3]: https://github.com/guanguans/monorepo-builder-worker/compare/1.1.2...1.1.3                           

                                                                                                                        
 [OK] Version "1.1.3" is now released!                                                                                  
                                                                                                                        
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

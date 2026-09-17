# monorepo-builder-worker

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> [!NOTE]
> A set of additional release workers for [symplify/monorepo-builder](https://github.com/symplify/monorepo-builder).

[![tests](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/tests.yml/badge.svg)](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/tests.yml)
[![php-cs-fixer](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/monorepo-builder-worker/actions/workflows/php-cs-fixer.yml)
[![codecov](https://codecov.io/gh/guanguans/monorepo-builder-worker/graph/badge.svg?token=0RtgSGom4K)](https://codecov.io/gh/guanguans/monorepo-builder-worker)
[![Latest Stable Version](https://poser.pugx.org/guanguans/monorepo-builder-worker/v)](https://packagist.org/packages/guanguans/monorepo-builder-worker)
[![GitHub release (with filter)](https://img.shields.io/github/v/release/guanguans/monorepo-builder-worker)](https://github.com/guanguans/monorepo-builder-worker/releases)
[![Total Downloads](https://poser.pugx.org/guanguans/monorepo-builder-worker/downloads)](https://packagist.org/packages/guanguans/monorepo-builder-worker)
[![License](https://poser.pugx.org/guanguans/monorepo-builder-worker/license)](https://packagist.org/packages/guanguans/monorepo-builder-worker)

## 环境要求

* PHP >= 8.2

## 安装

```shell
composer require guanguans/monorepo-builder-worker --dev --ansi -v
```

## 使用

### 示例

* [:monocle_face: Releases](https://github.com/guanguans/monorepo-builder-worker/releases)
* [:monocle_face: CHANGELOG.md](CHANGELOG.md)

### 在你的 `monorepo-builder` [配置](monorepo-builder.php)中注册工作者

```php
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CheckEnvironmentReleaseWorker;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\CreateGithubReleaseReleaseWorker;
use Guanguans\MonorepoBuilderWorker\ReleaseWorker\UpdateChangelogViaGoReleaseWorker;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;

return static function (MBConfig $mbConfig): void {
    $mbConfig->workers([
        CheckEnvironmentReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        UpdateChangelogViaGoReleaseWorker::class,
        CreateGithubReleaseReleaseWorker::class,
        // Other release workers...
    ]);

    CheckEnvironmentReleaseWorker::configure($mbConfig);
};
```

### 运行命令

```shell
╰─ vendor/bin/monorepo-builder release patch --ansi -v                                                              ─╯

 ! [NOTE] Checking environment...                                                                                       


 ! [NOTE] Running process: git-chglog -v                                                                                

 ! [NOTE] Running process: gh auth status                                                                               

 ! [NOTE] Running process: gh release list --limit 1                                                                    

 ! [NOTE] Environment checked!                                                                                          


 ! [NOTE] Running process: git tag -l --sort=committerdate                                                              

1/4) Add local tag "2.0.1"
==========================

class: Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker

 ! [NOTE] Running process: git add . && git commit -m "prepare release" && git push origin "main"                       

 ! [NOTE] Running process: git tag 2.0.1                                                                                

2/4) Push "2.0.1" tag to remote repository
==========================================

class: Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker

 ! [NOTE] Running process: git push --tags                                                                              

3/4) Update changelog "2.0.1 (2025-04-07)"
==========================================

class: Guanguans\MonorepoBuilderWorker\GoUpdateChangelogReleaseWorker

 ! [NOTE] Running process: git-chglog --output CHANGELOG.md                                                             

 ! [NOTE] Running process: git add CHANGELOG.md && git commit -m "chore(release): 2.0.1" --no-verify && git push        

 ! [NOTE] Running process: git-chglog 2.0.1                                                                             

4/4) Create github release "2.0.1"
==================================

class: Guanguans\MonorepoBuilderWorker\CreateGithubReleaseWorker

 ! [NOTE] Running process: gh release create 2.0.1 --notes <a name="2.0.1"></a>                                         
 !        ## [2.0.1] - 2025-04-07
 !        ### ✨ Features
 !        - **rector:** Add AddDocCommentsToDeclareRector functionality ([9d35c08](https://github.com/guanguans/monorepo-builder-worker/commit/9d35c08))
 !        
 !        ### 🐞 Bug Fixes
 !        - **EnvironmentChecker:** Improve namespace prefix handling ([7437c0e](https://github.com/guanguans/monorepo-builder-worker/commit/7437c0e))
 !        - **config:** Enable final flags in various methods ([d25cde1](https://github.com/guanguans/monorepo-builder-worker/commit/d25cde1))
 !        - **scripts:** Update Namespace Prefix Fix Method Reference ([aae90a1](https://github.com/guanguans/monorepo-builder-worker/commit/aae90a1))
 !        
 !        ### 💅 Code Refactorings
 !        - apply rector ([695b1c4](https://github.com/guanguans/monorepo-builder-worker/commit/695b1c4))
 !        - **CreateGithubReleaseReleaseWorker:** Simplify changelog retrieval ([032bb46](https://github.com/guanguans/monorepo-builder-worker/commit/032bb46))
 !        - **core:** Enhance configuration and class handling ([ffe041c](https://github.com/guanguans/monorepo-builder-worker/commit/ffe041c))
 !        - **helpers:** Optimize class loading logic in classes() function ([16a7ad1](https://github.com/guanguans/monorepo-builder-worker/commit/16a7ad1))
 !        
 !        ### ✅ Tests
 !        - Add initial test files and functionality ([2beb107](https://github.com/guanguans/monorepo-builder-worker/commit/2beb107))
 !        - **Helpers:** Add test for classes retrieval ([f965e62](https://github.com/guanguans/monorepo-builder-worker/commit/f965e62))
 !        
 !        ### 🤖 Continuous Integrations
 !        - **tests:** Check and fix namespace prefix in workflow ([f465092](https://github.com/guanguans/monorepo-builder-worker/commit/f465092))
 !        - **workflows:** Fix monorepo builder prefix command ([d449138](https://github.com/guanguans/monorepo-builder-worker/commit/d449138))
 !                                                                                                                      
 !                                                                                                                      
 !        [2.0.1]: https://github.com/guanguans/monorepo-builder-worker/compare/2.0.0...2.0.1                           

                                                                                                                        
 [OK] Version "2.0.1" is now released!                                                                                  
                                                                                                                        
```

## Composer 脚本

```shell
composer checks:required
composer php-cs-fixer:fix
composer ecs:fix
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

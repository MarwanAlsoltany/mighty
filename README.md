<!-- add a logo here if there is any, a <br/> after the image is recommended -->

<h1 align="center"><i>%[packageName]%</i></h1>

<div align="center">

%[description]%

<!-- variable are defined at the end of the file -->

[![PHP Version][php-icon]][php-href]
[![Latest Version on Packagist][version-icon]][version-href]
[![Total Downloads][downloads-icon]][downloads-href]
[![License][license-icon]][license-href]
[![Maintenance][maintenance-icon]][maintenance-href]
[![Documentation][documentation-icon]][documentation-href]
<br>
[![GitHub Continuous Integration][github-ci-icon]][github-ci-href]
[![GitHub Continuous Deployment][github-cd-icon]][github-cd-href]
[![Codecov][codecov-icon]][codecov-href]
<!-- [![Codacy Coverage][codacy-coverage-icon]][codacy-coverage-href] -->
<!-- [![Codacy Grade][codacy-grade-icon]][codacy-grade-href] -->

[![Open in Visual Studio Code][vscode-icon]][vscode-href]

[![Tweet][tweet-icon]][tweet-href] [![Star][github-stars-icon]][github-stars-href]

<details>
<summary>Table of Contents</summary>
<p>

[About](#about)<br/>
[Installation](#installation)<br/>
[Examples](#examples)<br/>
[More](#more)<br/>
[Changelog](./CHANGELOG.md)

</p>
</details>

<br/>

<sup>If you like this project and would like to support its development, giving it a :star: would be appreciated!</sup>

<!-- add an image here if there is any, a <br/> before the image is recommended -->

</div>


---


## Post Fork

This repository is a template for PHP packages.

### Placeholders

After forking this repository, some placeholders have to be replaced/updated with their corresponding values.

Available placeholders are:
- `%[author]%`: The name of the author (normally the same as GitHub username).
- `%[authorName]%`: The nice name of the author (capitalized name, as normally written).
- `%[authorEmail]%`: The email of the author.
- `%[package]%`: The name of the package (normally the same as GitHub repository name).
- `%[packageName]%`: The nice name of the package (capitalized version).
- `%[year]%`: The project year in YYYY format.
- `%[description]%`: The package description/summary.
- `Package\Vendor` namespace placeholder.

The regex for searching all placeholders is `/(%\[(.+?)\]%|Vendor\\[\\]?Package)/` and for a specific placeholder `/%\[placeholder\]%/` (or simply placeholder name).
Simply use IDE Search & Replace feature to replace placeholders with their corresponding values.

**NOTE:** You wouldn't be able to run `composer install` until the placeholders in `composer.json` required to pass the schema check are replaced.

### Contents

#### Build-Tools

This template is set up to use the following development tools:
- [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) (coding standard fixer)
- [PHPStan](https://github.com/phpstan/phpstan) (static analysis)
- [PHPUnit](https://github.com/sebastianbergmann/phpunit) (testing)
- [PHPBench](https://github.com/phpbench/phpbench) (benchmarking)
- [Doctum](https://github.com/code-lts/doctum) (API documentation)

> See `composer.json` `"scripts"` for more information.

#### CI/CD-Tools

This template is set up to use GitHub Actions as CI/CD Pipeline with the following tools:
- [Composer](https://github.com/composer/composer) (CI/CD)
- [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) (CI)
- [PHPStan](https://github.com/phpstan/phpstan) (CI)
- [PHPUnit](https://github.com/sebastianbergmann/phpunit) (CI)
- [PHPBench](https://github.com/phpbench/phpbench) (CI)
- [Doctum](https://github.com/code-lts/doctum) (CD)
- [Codecov](https://codecov.io/) (CI)
- [Codacy](https://www.codacy.com/) (CI) [optional, disabled by default]

The [Codecov](https://codecov.io/) and [Codacy](https://www.codacy.com/) tools won't work until an account in the corresponding service is created and pointed to the repository.

The configuration files for these tools are already set up. Some extra configuration may be required as per project requirements.

Some small things still need to be taken care of:
1. Rename the directory `.github/workflows.disabled` to `.github/workflows` to enable GitHub Actions workflows (this done like this to prevent GitHub from running the workflows before the project is ready).
2. After the first successful run of the CI/CD workflows, enable GitHub Pages via Repository Settings. Set the "Source" as "Deploy from a branch", the "Branch" as `gh-pages` and the "Folder" as you like.
3. If you are not planning to use the provided Github Actions workflows. The generated API documentation will be created under `build/doctum`. Create an orphan branch named `gh-pages` and push the generated files to it then enabled GitHub pages for the repository.

#### Directory Structure

- `.github/`: GitHub specific configuration files. <sup>(required; contains: workflows, templates for PRs/contributing/issue, funding, etc ...)</sup>
- `art/`: This where you add visual assets that are related to the project (logos, demo images). <sup>(optional; can be deleted)</sup>
- `bin/`: This where you add scripts that are used in the project or should be provided for Composer. <sup>(optional; can be deleted)</sup>
- `build/`: This where build artifacts generated by development tools will be placed. <sup>(optional; can be deleted, will be generated automatically)</sup>
- `docs/`: This where you should add your project documentation (`gh-pages` branch is recommended). <sup>(does not exist; only for reference)</sup>
- `dist/`: This where you should add your project distribution files and packages. <sup>(optional; can be deleted)</sup>
- `src/`: This where you add your project source files. <sup>(required)</sup>
- `tests/`: This where you add your project tests and benchmarks. <sup>(required)</sup>
- `vendor/`: This where Composer dependencies will be installed. <sup>(does not exist; only for reference)</sup>
- `/`: The root directory of the project will contain other files like build tools configuration files, dependency manger files, documentation files, etc ...

#### Dummy Files

The template contains some dummy files that can be deleted if not needed. These files are listed below:
- `bin/executable`
- `src/Main.php`
- `tests/Tests/MainTest.php`
- `tests/Benchmarks/MainBench.php`
- `**/*/.gitkeep`

#### Finally

Adjust all files to you needs (*Search & Replace*, *Edit* or *Delete*), delete the "Post Fork" section from the `README.md` file and add some content to it. Finally commit the initial commit.

Add some glare to your `README.md` file using:

![■[H]](https://user-images.githubusercontent.com/7969982/182090863-c6bf7159-7056-4a00-bc97-10a5d296c797.png) **Hint:** *Here is some **hint** for you!*

![■[F]](https://user-images.githubusercontent.com/7969982/182090858-f98dc83e-da1c-4f14-a538-8ac0a9bc43c3.png) **Fact:** *Here is some **fact** for you!*

![■[N]](https://user-images.githubusercontent.com/7969982/182090864-09a2573a-59e3-4c82-bf9f-e2b9cd360c27.png) **Note:** *Here is some **note** for you!*

---


## Key Features

1. One
2. Two
3. ...


---


## About

Add a description here ...


---


## Installation

#### Using Composer:

Install %[packageName]% through Composer using:

```sh
composer require %[author]%/%[package]%
```

<!-- add as many installation methods here as needed -->


---


## Examples

Add some examples here ...

```php

// add some code here

```


---


## More

Add as many sections as needed ...


---


## License

%[packageName]% is an open-source project licensed under the [**MIT**](./LICENSE) license.
<br/>
Copyright (c) %[year]% %[authorName]%. All rights reserved.
<br/>










<!-- edit icons as needed -->
[php-icon]: https://img.shields.io/badge/php-%3E=8.0-yellow?style=flat&logo=php
[version-icon]: https://img.shields.io/packagist/v/%[author]%/%[package]%.svg?style=flat&logo=packagist
[downloads-icon]: https://img.shields.io/packagist/dt/%[author]%/%[package]%.svg?style=flat&logo=packagist
[license-icon]: https://img.shields.io/badge/license-MIT-red.svg?style=flat&logo=github
[maintenance-icon]: https://img.shields.io/badge/maintained-yes-orange.svg?style=flat&logo=github
[documentation-icon]: https://img.shields.io/website-up-down-blue-red/http/%[author]%.github.io/%[package]%.svg
<!-- GitHub Actions native badges -->
<!-- [github-ci-icon]: https://github.com/%[author]%/%[package]%/actions/workflows/ci.yml/badge.svg -->
<!-- [github-cd-icon]: https://github.com/%[author]%/%[package]%/actions/workflows/cd.yml/badge.svg -->
[github-ci-icon]: https://img.shields.io/github/workflow/status/%[author]%/%[package]%/CI?style=flat&logo=github
[github-cd-icon]: https://img.shields.io/github/workflow/status/%[author]%/%[package]%/CD?style=flat&logo=github
[codecov-icon]: https://codecov.io/gh/%[author]%/%[package]%/branch/master/graph/badge.svg?token=CODECOV_TOKEN
<!-- [codacy-coverage-icon]: https://app.codacy.com/project/badge/Coverage/YOUR_CODACY_PROJECT_TOKEN -->
<!-- [codacy-grade-icon]: https://app.codacy.com/project/badge/Grade/YOUR_CODACY_PROJECT_TOKEN -->
[vscode-icon]: https://img.shields.io/static/v1?logo=visualstudiocode&label=&message=Open%20in%20VS%20Code&labelColor=2c2c32&color=007acc&logoColor=007acc
[tweet-icon]: https://img.shields.io/twitter/url/http/shields.io.svg?style=social
[github-stars-icon]: https://img.shields.io/github/stars/%[author]%/%[package]%.svg?style=social&label=Star

<!-- edit urls as needed -->
[php-href]: https://github.com/%[author]%/%[package]%/search?l=php
[version-href]: https://packagist.org/packages/%[author]%/%[package]%
[downloads-href]: https://packagist.org/packages/%[author]%/%[package]%/stats
[license-href]: ./LICENSE
[maintenance-href]: https://github.com/%[author]%/%[package]%/graphs/commit-activity
[documentation-href]: https://%[author]%.github.io/%[package]%
[github-ci-href]: https://github.com/%[author]%/%[package]%/actions
[github-cd-href]: https://github.com/%[author]%/%[package]%/actions
[codecov-href]: https://codecov.io/gh/%[author]%/%[package]%
<!-- [codacy-coverage-href]: https://app.codacy.com/project/badge/Coverage/YOUR_CODACY_PROJECT_TOKEN -->
<!-- [codacy-grade-href]: https://app.codacy.com/project/badge/Grade/YOUR_CODACY_PROJECT_TOKEN -->
[vscode-href]: https://open.vscode.dev/%[author]%/%[package]%
[tweet-href]: https://twitter.com/intent/tweet?url=https%3A%2F%2Fgithub.com%2F%[author]%%2F%[package]%&text=Check%20out%%[author]%%2F%[package]%%20on%20GitHub%21
[github-stars-href]: https://github.com/%[author]%/%[package]%/stargazers

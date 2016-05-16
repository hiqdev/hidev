HiDev
=====

**Task runner, code generator and build tool for easier continuos integration**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/hidev/v/stable)](https://packagist.org/packages/hiqdev/hidev)
[![Total Downloads](https://poser.pugx.org/hiqdev/hidev/downloads)](https://packagist.org/packages/hiqdev/hidev)
[![Build Status](https://img.shields.io/travis/hiqdev/hidev.svg)](https://travis-ci.org/hiqdev/hidev)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/hidev.svg)](https://scrutinizer-ci.com/g/hiqdev/hidev/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/hidev.svg)](https://scrutinizer-ci.com/g/hiqdev/hidev/)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:hidev/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:hidev/dev-master)

Features:

- package management: [Composer](https://getcomposer.org/), [Packagist](https://packagist.org/)
- release automation: README, LICENSE, CHANGELOG, version bump
- CI services: [Travis](https://travis-ci.org/), [Scrutinizer](https://scrutinizer-ci.com/)
- testing: [PHPUnit](https://phpunit.de/), [Codeception](http://codeception.com/)
- code quality: [PHP-CS-Fixer](http://cs.sensiolabs.org/), [VersionEye](https://www.versioneye.com/)
- version control: .gitignore, commits history
- PHAR building with [Box](https://github.com/box-project/box2)
- code generation with php and twig templates

And more planned. See [ROADMAP](ROADMAP.md).

## Installation

There are several ways of installation in order of preference:

1. download PHAR from http://hiqdev.com/hidev/hidev.phar
2. require `hiqdev/hidev` in your project's composer.json
3. install globally with `composer global require "hiqdev/hidev:*"`

## Idea

The main idea behind HiDev is to combine code generator and build tool to stop
copying config files between your projects. And automate all the repeated tasks
of course. But firstly generate all the files that can be generated, e.g.:

- `.gitignore`, `README.md`, `LICENSE`, `CHANGELOG.md`
- `composer.json`
- `.travis.yml`, `.scrutinizer.yml`
- `phpunit.xml`, `codeception.yml`
- `.php_cs`
- skeleton source and test files

You write a simple config specifying general information about your package
and plugins to be used. HiDev alone does nothing at all! You specify what
you want it to do in config or use plugins. There are predefined plugins with
generally usable configs or you can create plugins yourself.

For example, `hiqdev/hidev-php` plugin is a general config for PHP projects and
will enable HiDev to create all the listed above files and adds goals to use:

- `hidev all` or simply `hidev` will update config files according to the changes you made
- `hidev fix`: will update `.php_cs` file and run `php-cs-fixer` to fix code style of your PHP files
- `hidev test`: will update `phpunit.xml` and run your tests with `phpunit`
- `hidev build`: will do fix and test alltogether
- `hidev codeception`: will bootstrap `codeception`, update it's config and run tests with it
- `hidev bump` and `hidev bump/release` will bump project version and publish release to GitHub

HiDev can generate different files: sources, tests, anything else based on templates and
all the information available in config files or elsewhere.

Now I'm working to enable HiDev to do more:

- project bootstraping and deploy
- integration with other build tools: robo, grunt, gulp, ...
- more for Python: pep8, tests, ...

## Configuration

HiDev keeps everything it needs: configs, plugins, intermediate files and so on
in `.hidev` directory in the root of your project.

The main config file is: `.hidev/config.yml`.

You can generate basic config file with **init** command:

```sh
hidev init the-vendor/my-new-package
```

You will receive:

```yaml
package:
    type:           project
    name:           my-new-package
    title:          My New Package
    keywords:       my, new, package

vendor:
    name:           the-vendor
    authors:
        hiqsol:
            name:       Andrii Vasyliev
            email:      sol@hiqdev.com

plugins:
    hiqdev/hidev-php: "*"
```

Package section holds info on the package:

- **name**: your package name, same as in package manager but without vendor name
- **title**: single line description of your package (description in composer.json)
- **type**, **keywords**: same as in package manager

Also you can add more info for better README generation:

- **headline**: short user friendly name of your project, used for README header
- **description**: longer description

Vendor section holds info about you or your company:

- **name**: same as in package manager
- **title**: full vendor name, will be used for README, LICENSE and so on
- **github**, **homepage**, **forum**, **email**: obviously
- **license**: will be used if package does not specify one
- **authors**: array of authors, see: HiQDev's [config.yml](https://github.com/hiqdev/hidev-vendor/blob/master/src/config.yml)

Best way of configuring vendor is to create and use your vendor plugin for HiDev.
It's easy, just copy `hiqdev/hidev-vendor`, change it appropriately and publish
to Packagist.

Plugins section lists the plugins mentioning versions to be used for your package.
Version constraints will be used with composer so must follow it's rules.

Good example of configuration is HiDev's own [.hidev/config.yml](.hidev/config.yml).

## Usage

Just run it.

```sh
hidev
```

And see the magic.

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2015-2016, HiQDev (http://hiqdev.com/)

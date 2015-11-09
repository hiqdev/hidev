HiDev - integrated development
==============================

**Task runner, code generator and build tool for easier continuos integration**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/hidev/v/stable)](//packagist.org/packages/hiqdev/hidev)
[![Total Downloads](https://poser.pugx.org/hiqdev/hidev/downloads)](//packagist.org/packages/hiqdev/hidev)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:hidev/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:hidev/dev-master)

Features:
- package management: composer.json, Packagist
- release automation: README, LICENSE, CHANGELOG
- code generation with php and twig templates
- VCS integration: .gitignore, commits history
- code quality: php-cs-fixer, VersionEye
- testing: codeception

And more planned. See [ROADMAP](https://github.com/hiqdev/hidev/blob/master/ROADMAP.md).

## Installation

The preferred way to install this project is through [composer](http://getcomposer.org/download/).

```
php composer.phar create-project "hiqdev/hidev:*" directory2install
```

## Configuration

HiDev keeps everything it needs: configs, plugins, intermediate files and so on
in **.hidev** directory in the root of your project.

The main config file is: **.hidev/config.yml**.

You can generate basic config file with **init** command:

```sh
hidev init the-vendor/my-package
```

You will receive:
```yml
package:
    name:           my-new-package
    type:           project
    keywords:       my, new, package

vendor:
    name:           the-vendor
    authors:
        'Andrii Vasyliev':
            email:      sol@hiqdev.com

require:
    hiqdev/hidev-config-php:    "*"
```

## Usage

Just run it.

```sh
hidev
```

And see the magic.

## License

This project is released under the terms of the BSD-3-Clause [license](https://github.com/hiqdev/hidev/blob/master/LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2014-2015, HiQDev (http://hiqdev.com/)

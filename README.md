HiDev
=====

**Task runner, code generator and build tool for easier continuos integration**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/hidev/v/stable)](//packagist.org/packages/hiqdev/hidev)
[![Total Downloads](https://poser.pugx.org/hiqdev/hidev/downloads)](//packagist.org/packages/hiqdev/hidev)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:hidev/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:hidev/dev-master)

Features:
- package management: Composer, Packagist
- release automation: README, LICENSE, CHANGELOG
- code generation with php and twig templates
- version control: .gitignore, commits history
- code quality: PHP-CS-Fixer, VersionEye
- testing: PHPUnit, Codeception

And more planned. See [ROADMAP](ROADMAP.md).

## Installation

The preferred way to install this project is through [composer](http://getcomposer.org/download/).

```sh
php composer.phar create-project "hiqdev/hidev:*" directory2install
```

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

require:
    hiqdev/hidev-php: "*"
```

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

Copyright © 2014-2015, HiQDev (http://hiqdev.com/)

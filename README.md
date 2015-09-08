HiDev - integrate your development
----------------------------------

Task runner, code generator and build tool for continuos integration.
- package management: composer.json
- release automation: README, LICENSE, CHANGELOG
- code generation with php and twig templates
- VCS integration: .gitignore, commits history
- code quality: php-cs-fixer
- testing: codeception

And more planned. See [ROADMAP](https://github.com/hiqdev/hidev/blob/master/ROADMAP.md).


[![Latest Stable Version](https://poser.pugx.org/hiqdev/hidev/v/stable.png)](https://packagist.org/packages/hiqdev/hidev)
[![Total Downloads](https://poser.pugx.org/hiqdev/hidev/downloads.png)](https://packagist.org/packages/hiqdev/hidev)

## Installation

The preferred way to install this project is through [composer](http://getcomposer.org/download/).

```
php composer.phar create-project "hiqdev/hidev:*" directory2install
```

## Configuration

HiDev keeps everything it needs: configs, plugins, intermediate files and so on
in **.hidev** directory in the root of your project.

The main config file is: **.hidev/config.yml**.

You can generate basic config file with init command:

    hidev init vendor/my-package

You will receive:
```yml
package:
    name:           my-package
    label:          MyPackage
    title:          My Package
    type:           package
    keywords:       my, package

require:
    vendor/hidev-config:        "*"
    hiqdev/hidev-config-php:    "*"
```

## Licence

[BSD-3-Clause](http://choosealicense.com/licenses/bsd-3-clause)

Copyright © 2014-2015, HiQDev (https://hiqdev.com/)

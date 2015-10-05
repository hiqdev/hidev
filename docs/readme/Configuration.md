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
    type:           project
    keywords:       my, package

require:
    vendor/hidev-config:        "*"
    hiqdev/hidev-config-php:    "*"
```

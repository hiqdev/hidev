HiDev keeps everything it needs: configs, plugins, intermediate files and so on
in **.hidev** directory in the root of your project.

The main config file is: **.hidev/config.yml**.

You can generate basic config file with **init** command:

```sh
hidev init the-vendor/my-package
```

You will receive:
```yaml
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

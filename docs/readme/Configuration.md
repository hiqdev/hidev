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

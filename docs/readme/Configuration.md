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

Require section lists the plugins mentioning versions to be used for your package.
Versions will be used with composer so must follow it's rules.

Good example of configuration is HiDev's own [.hidev/config.yml](.hidev/config.yml).


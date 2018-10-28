The main config file is: `hidev.yml`.

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
```

Package section holds info about the package:

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
- **authors**: array of authors, see: [HiQDev's config](https://github.com/hiqdev/hidev-hiqdev/blob/master/config/goals.yml)

Best way to configure vendor is to create and use your vendor plugin for HiDev.
It's easy, just fork `hiqdev/hidev-hiqdev`, change it appropriately and publish
to Packagist.

For examples of HiDev configuration you can see [our repos on GitHub],
all of them are automated with HiDev.

[our repos on GitHub]: https://github.com/hiqdev

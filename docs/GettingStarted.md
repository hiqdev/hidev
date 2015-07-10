# Getting started

## Requirements

All you need is cli PHP and composer.

## Instalation

Hidev and plugins are installed with composer.

Globally:

~~~
composer global require hiqdev/hidev
~~~

Or locally at every project with require-dev in composer.json file.

## config

Hidev keeps everything it needs: configs, plugins, intermediate files and so on in .hidev directory in the root of your project.
The main config file is: .hidev/config.yml.
Also .yaml extension can be used instead of .yml and JSON format works as well.


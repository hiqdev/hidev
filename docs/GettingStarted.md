# Getting started

# Requirements 

All you need is cli PHP and composer.

## Instalation

Hidev and plugins are installed with composer.
 
Hidev can be installed globally:

composer global require hiqdev/hidev

Or locally at every project with require-dev in composer.json file, which is preffered cause this way you can have different set of plugins for that project.

You better have both. Globally installed hidev will look for locally installed hidev and run it instead when run from any project directory.

## Hidev's directory 

Hidev keeps everything it needs: configs, intermediate files and so on in .hidev directory in the root of your project. 
The main config file is: .hidev/config.yml. 
Also .yaml extension can be used instead of .yml and JSON format works as well.  


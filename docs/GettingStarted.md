# Getting started

# Requirements 

All you need is cli PHP and composer.

## Instalation

Install with composer. 
Hidev can be installed globally, which is preferred:

composer global require hiqdev/hidev

Or locally at every project with require-dev in composer.json file, but I don't know a single reason for that. 

Hidev installs required plugins on it's own so you don't need to install them manually. 

## Hidev's directory 

Hidev keeps everything it needs: configs, intermediate files, plugins and so on in .hidev directory in the root of your project. 
The main config file is: .hidev/config.yml. 
yaml extension can be used instead of yml and JSON works as well.  


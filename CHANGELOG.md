hiqdev/hidev changelog
----------------------

## 0.3.0 2016-01-15

- Added history cleaning from 'Under development' section if it is empty
- Added `bump` goal for version bumping
- Fixed tests
- Added installing and vcsignoring PHAR for required binaries
- Changed: renamed hidev-travis-ci -> hidev-travis
- Changed: redone goals -> controllers
- Added `dump` goal
- Changed: redone with `composer-extension-plugin` instead of PluginManager
- Fixed to use latest Symfony YAML 3.0 <- 2.7
- Fixed minor issues
- Added `github/clone` action, NOT finished

## 0.2.0 2015-12-23

- Added runRequest and runRequests at DefaultGoal
- Fixed Travis build
- Added `update` goal
- Changed finding goal class
- Fixed InstallGoal::detectBin
- Changed: moved README goal to `hidev-readme` plugin
- Fixed PHP7 warnings
- Added phar compatibility
- Fixed minii requirements
- Added `GitHubGoal`

## 0.1.7 2015-12-04

- CHANGED: redone to `minii` and BROKEN build temporary
- Fixed badges generation
- Fixed vcsignoring implementation
- Added exit code propagation and running commands facilities
- Changed: license generation moved to `hidev-license` plugin
- Added `XmlHandler`
- Added PHPUnit integration with `hidev-phpunit` plugin
- Added Travis CI integration with `hidev-travis-ci` plugin
- Added more options to init goal
- Fixed and improved tests and minor issues

## 0.1.6 2015-11-09

- Fixed composer.json generation: follow schema, only name, role, email and homepage for authors

## 0.1.5 2015-11-09

- Added support for VCS ignoring list configuring in plugins

## 0.1.4 2015-11-09

- Fixed php short tags

## 0.1.3 2015-11-06

- Fixed 'hidev update' to do default procedure after updating
- Changed README generation: added package headline

## 0.1.2 2015-10-26

- Added basic Usage readme section
- Added control of readme sections to be rendered
- Added 'update' goal to update hidev internals

## 0.1.1 2015-10-25

- Added better badges configuring and rendering
- Fixed package title to: HiDev - integrated development
- Fixed getRepositoryUrl

## 0.1.0 2015-10-15

- Added improved README generation with render functions and section templates
- Changed License section in README
- Changed default config generated with 'hidev init': added authors and more options
- Added tests for README goal
- Added tests for 'hidev init'
- Fixed exception catching for proper showing user errors

## 0.0.10 2015-09-09

- Fixed init: made even smaller basic config
- Fixed getting/setting namespace

## 0.0.9 2015-09-08

- Added VersionEye badge generation
- Added showing user errors (instead of exception stack trace)
- Added init command: hidev init vendor/package
- Removed 'runtime' gitignoring by default

## 0.0.8 2015-08-17

- Added better README generation with badges and additional sections
- Added runAction/s
- Changed determining done
- Fixed minor bugs
- Changed .gitignore generation, now built from hashmap with comments
- Changed config: redone parent with plugins
- Changed source dir: moved to src
- Added initial Getting started doc
- Changed change log to follow keepachangelog.com recomendations
- Changed roadmap
- Added tests
- Added generate goal: generate file by template and params
- Added codeception plugin
- Changed config loading
- Changed: redone goals like controllers

## 0.0.7 2015-06-19

- Changed composer.json: dont add empty require
- Fixed code styling with php-cs-fixer
- Added php-cs-fixer plugin
- Added plugin archtecture
- Fixed portability

## 0.0.6 June 6, 2015

- Changed: GREAT RENAMING OF CLASSES
- Added cool CHANGELOG.md generation
- Added gen action to generate files by templates
- Added "No licence" default license

## 0.0.5 June 1, 2015

- Changed decreased default verbosity

## 0.0.4 June 1, 2015

- Added twig templates

## 0.0.3 June 1, 2015

- Added YAML config
- Added ROADMAP.md

## 0.0.2 May 30, 2015

- Added parent config
- Added use of Robo (started robo integration)
- Changed namespace to 'hidev'
- Fixed different minor thing

## 0.0.1 May 12, 2015

- Added basics
- Added colorized console output
- Added README.md generation
- Added CHANGELOG.md generation
- Added composer.json generation
- Added simple .gitignore generation
- Added LICENSE generation

## Development started April 28, 2015


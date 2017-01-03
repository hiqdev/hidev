hiqdev/hidev
------------

## [0.5.1] - 2017-01-03

- Changed getting config assembled with composer-config-plugin ([@hiqsol], [@SilverFire])
- Added basic `update` action ([@hiqsol])
- Added installation configs for composer and pip ([@hiqsol])
- Fixed writing `.hidev/composer.json`, now mergning ([@hiqsol])
- Added more python compatibility ([@hiqsol])
- Added creating `composer.json` at `init` ([@hiqsol])
- Added [Yii built-in controllers] ([@hiqsol])

## [0.5.0] - 2016-08-01

- Changed bumping with use of `chkipper` ([@hiqsol])
- Fixed package title ([@hiqsol])
- Added including of `.hidev/config-local.yml` ([@hiqsol])
- Fixed functional tester ([@hiqsol])

## [0.4.0] - 2016-05-21

- Changed: redone to `composer-config-plugin` ([@hiqsol])
- Changed: greatly improved functional tests ([@hiqsol])
- Fixed minor issues ([@hiqsol])
- Added sudo modifier ([@hiqsol])
- Added `@root` instead of `@prjdir` ([@hiqsol])
- Added `hidev help` ([@hiqsol])
- Added copying in `FileController` ([@hiqsol])
- Changed `require:` option to `plugins:` ([@hiqsol])
- Added `CommandController` ([@hiqsol])
- Added `dump/internals` action ([@hiqsol])
- Changed to use `hiqdev/composer-extension-plugin` instead of PluginManager ([@hiqsol])
- Added `github/create` and `github/exists` actions ([@hiqsol])
- Changed back to yii2 <- minii, used `asset-packagist.hiqdev.com` repository ([@hiqsol])
- Added loading of project's own bootstrap and config ([@hiqsol])
- Added better defaults when package name is domain ([@hiqsol])
- Changed github `name` -> `full_name` to correspond github api ([@hiqsol])
- Fixed scrutinizer issues ([@hiqsol])
- Added smart vendor require in `hidev/init` ([@hiqsol])
- Fixed `bump` and `bump/release` ([@hiqsol])
- Added easy creation of templated dirs and files with `DirectoryController` ([@hiqsol])
- Fixed `JsonHandler` to parse empty JSON to empty array (died before) ([@hiqsol])

## [0.3.9] - 2016-01-26

- Fixed to work for projects without package manager ([@hiqsol])
- Fixed GitHub token passing to curl ([@hiqsol])

## [0.3.8] - 2016-01-26

- Added `bump/release` and `github/release` actions to automate release ([@hiqsol])
- Fixed minor issues ([@hiqsol])

## [0.3.7] - 2016-01-19

- Added getting default package start year with git log ([@hiqsol])
- Added CollectionController ([@hiqsol])
- Fixed: improved travis `before_install` section ([@hiqsol])

## [0.3.6] - 2016-01-17

- Added `version` goal and OwnVersionController for better version management ([@hiqsol])

## [0.3.5] - 2016-01-16

- Fixed minor and tested version bump ([@hiqsol])

## [0.3.4] - 2016-01-16

- Fixed `bump/commit` to default to current version ([@hiqsol])
- Fixed hidev own version showing ([@hiqsol])

## [0.3.3] - 2016-01-16

- Added proper version bumping with `version/bump` and `bump` ([@hiqsol])
- Added version output with `hidev --version` or `hidev version` ([@hiqsol])

## [0.3.2] - 2016-01-16

- Added sorting inside `.gitignore` sections ([@hiqsol])
- Fixed PHAR building ([@hiqsol])

## [0.3.1] - 2016-01-15

- Added `bump/commit` action ([@hiqsol])

## [0.3.0] - 2016-01-15

- Added history cleaning from 'Under development' section if it is empty ([@hiqsol])
- Added `bump` goal for version bumping ([@hiqsol])
- Fixed tests ([@hiqsol])
- Added installing and vcsignoring PHAR for required binaries ([@hiqsol])
- Changed: renamed hidev-travis-ci -> hidev-travis ([@hiqsol])
- Changed: redone goals -> controllers ([@hiqsol])
- Added `dump` goal ([@hiqsol])
- Changed: redone with `composer-extension-plugin` instead of PluginManager ([@hiqsol])
- Fixed to use latest Symfony YAML 3.0 <- 2.7 ([@hiqsol])
- Fixed minor issues ([@hiqsol])
- Added `github/clone` action, NOT finished ([@hiqsol])

## [0.2.0] - 2015-12-23

- Added runRequest and runRequests at DefaultGoal ([@hiqsol])
- Fixed Travis build ([@hiqsol])
- Added `update` goal ([@hiqsol])
- Changed finding goal class ([@hiqsol])
- Fixed InstallGoal::detectBin ([@hiqsol])
- Changed: moved README goal to `hidev-readme` plugin ([@hiqsol])
- Fixed PHP7 warnings ([@hiqsol])
- Added phar compatibility ([@hiqsol])
- Fixed minii requirements ([@hiqsol])
- Added `GitHubGoal` ([@hiqsol])

## [0.1.7] - 2015-12-04

- CHANGED: redone to `minii` and BROKEN build temporary ([@hiqsol])
- Fixed badges generation ([@hiqsol])
- Fixed vcsignoring implementation ([@hiqsol])
- Added exit code propagation and running commands facilities ([@hiqsol])
- Changed: license generation moved to `hidev-license` plugin ([@hiqsol])
- Added `XmlHandler` ([@hiqsol])
- Added PHPUnit integration with `hidev-phpunit` plugin ([@hiqsol])
- Added Travis CI integration with `hidev-travis-ci` plugin ([@hiqsol])
- Added more options to init goal ([@hiqsol])
- Fixed and improved tests and minor issues ([@hiqsol])

## [0.1.6] - 2015-11-09

- Fixed composer.json generation: follow schema, only name, role, email and homepage for authors ([@hiqsol])

## [0.1.5] - 2015-11-09

- Added support for VCS ignoring list configuring in plugins ([@hiqsol])

## [0.1.4] - 2015-11-09

- Fixed php short tags ([@hiqsol])

## [0.1.3] - 2015-11-06

- Fixed 'hidev update' to do default procedure after updating ([@hiqsol])
- Changed README generation: added package headline ([@hiqsol])

## [0.1.2] - 2015-10-26

- Added basic Usage readme section ([@hiqsol])
- Added control of readme sections to be rendered ([@hiqsol])
- Added 'update' goal to update hidev internals ([@hiqsol])

## [0.1.1] - 2015-10-25

- Added better badges configuring and rendering ([@hiqsol])
- Fixed package title to: HiDev - integrated development ([@hiqsol])
- Fixed getRepositoryUrl ([@hiqsol])

## [0.1.0] - 2015-10-15

- Added improved README generation with render functions and section templates ([@hiqsol])
- Changed License section in README ([@hiqsol])
- Changed default config generated with 'hidev init': added authors and more options ([@hiqsol])
- Added tests for README goal ([@hiqsol])
- Added tests for 'hidev init' ([@hiqsol])
- Fixed exception catching for proper showing user errors ([@hiqsol])

## [0.0.10] - 2015-09-09

- Fixed init: made even smaller basic config ([@hiqsol])
- Fixed getting/setting namespace ([@hiqsol])

## [0.0.9] - 2015-09-08

- Added VersionEye badge generation ([@hiqsol])
- Added showing user errors (instead of exception stack trace) ([@hiqsol])
- Added init command: hidev init vendor/package ([@hiqsol])
- Removed 'runtime' gitignoring by default ([@hiqsol])

## [0.0.8] - 2015-08-17

- Added better README generation with badges and additional sections ([@hiqsol])
- Added runAction/s ([@hiqsol])
- Changed determining done ([@hiqsol])
- Fixed minor bugs ([@hiqsol])
- Changed .gitignore generation, now built from hashmap with comments ([@hiqsol])
- Changed config: redone parent with plugins ([@hiqsol])
- Changed source dir: moved to src ([@hiqsol])
- Added initial Getting started doc ([@hiqsol])
- Changed change log to follow keepachangelog.com recomendations ([@hiqsol])
- Changed roadmap ([@hiqsol])
- Added tests ([@hiqsol])
- Added generate goal: generate file by template and params ([@hiqsol])
- Added codeception plugin ([@hiqsol])
- Changed config loading ([@hiqsol])
- Changed: redone goals like controllers ([@hiqsol])

## [0.0.7] - 2015-06-19

- Changed composer.json: dont add empty require ([@hiqsol])
- Fixed code styling with php-cs-fixer ([@hiqsol])
- Added php-cs-fixer plugin ([@hiqsol])
- Added plugin archtecture ([@hiqsol])
- Fixed portability ([@hiqsol])

## [0.0.6] - 2015-06-06

- Changed: GREAT RENAMING OF CLASSES ([@hiqsol])
- Added cool CHANGELOG.md generation ([@hiqsol])
- Added gen action to generate files by templates ([@hiqsol])
- Added "No licence" default license ([@hiqsol])

## [0.0.5] - 2015-06-01

- Changed decreased default verbosity ([@hiqsol])

## [0.0.4] - 2015-06-01

- Added twig templates ([@hiqsol])

## [0.0.3] - 2015-06-01

- Added YAML config ([@hiqsol])
- Added ROADMAP.md ([@hiqsol])

## [0.0.2] - 2015-05-30

- Added parent config ([@hiqsol])
- Added use of Robo (started robo integration)
- Changed namespace to 'hidev' ([@hiqsol])
- Fixed different minor thing ([@hiqsol])

## [0.0.1] - 2015-05-12

- Added basics
- Added colorized console output ([@hiqsol])
- Added README.md generation
- Added CHANGELOG.md generation ([@hiqsol])
- Added composer.json generation ([@hiqsol])
- Added simple .gitignore generation ([@hiqsol])
- Added LICENSE generation ([@hiqsol])

## [Development started] - 2015-04-28

[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[Yii built-in controllers]: http://www.yiiframework.com/doc-2.0/guide-tutorial-console.html
[Under development]: https://github.com/hiqdev/hidev/compare/0.5.0...HEAD
[0.5.0]: https://github.com/hiqdev/hidev/compare/0.4.0...0.5.0
[0.4.0]: https://github.com/hiqdev/hidev/compare/0.3.9...0.4.0
[0.3.9]: https://github.com/hiqdev/hidev/compare/0.3.8...0.3.9
[0.3.8]: https://github.com/hiqdev/hidev/compare/0.3.7...0.3.8
[0.3.7]: https://github.com/hiqdev/hidev/compare/0.3.6...0.3.7
[0.3.6]: https://github.com/hiqdev/hidev/compare/0.3.5...0.3.6
[0.3.5]: https://github.com/hiqdev/hidev/compare/0.3.4...0.3.5
[0.3.4]: https://github.com/hiqdev/hidev/compare/0.3.3...0.3.4
[0.3.3]: https://github.com/hiqdev/hidev/compare/0.3.2...0.3.3
[0.3.2]: https://github.com/hiqdev/hidev/compare/0.3.1...0.3.2
[0.3.1]: https://github.com/hiqdev/hidev/compare/0.3.0...0.3.1
[0.3.0]: https://github.com/hiqdev/hidev/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/hiqdev/hidev/compare/0.1.7...0.2.0
[0.1.7]: https://github.com/hiqdev/hidev/compare/0.1.6...0.1.7
[0.1.6]: https://github.com/hiqdev/hidev/compare/0.1.5...0.1.6
[0.1.5]: https://github.com/hiqdev/hidev/compare/0.1.4...0.1.5
[0.1.4]: https://github.com/hiqdev/hidev/compare/0.1.3...0.1.4
[0.1.3]: https://github.com/hiqdev/hidev/compare/0.1.2...0.1.3
[0.1.2]: https://github.com/hiqdev/hidev/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/hiqdev/hidev/compare/0.1.0...0.1.1
[0.1.0]: https://github.com/hiqdev/hidev/compare/0.0.10...0.1.0
[0.0.10]: https://github.com/hiqdev/hidev/compare/0.0.9...0.0.10
[0.0.9]: https://github.com/hiqdev/hidev/compare/0.0.8...0.0.9
[0.0.8]: https://github.com/hiqdev/hidev/compare/0.0.7...0.0.8
[0.0.7]: https://github.com/hiqdev/hidev/compare/0.0.6...0.0.7
[0.0.6]: https://github.com/hiqdev/hidev/compare/0.0.5...0.0.6
[0.0.5]: https://github.com/hiqdev/hidev/compare/0.0.4...0.0.5
[0.0.4]: https://github.com/hiqdev/hidev/compare/0.0.3...0.0.4
[0.0.3]: https://github.com/hiqdev/hidev/compare/0.0.2...0.0.3
[0.0.2]: https://github.com/hiqdev/hidev/compare/0.0.1...0.0.2
[0.0.1]: https://github.com/hiqdev/hidev/releases/tag/0.0.1
[0.5.1]: https://github.com/hiqdev/hidev/compare/0.5.0...0.5.1

hiqdev/hidev commits history
----------------------------

## Under development

- Fixed using for Travis build
    - 93f3510 2015-12-15 fixed travis config: dont build 5.4 and dont allow failure 7 (sol@hiqdev.com)
    - ce3ad2d 2015-12-15 - hidev from install (sol@hiqdev.com)
- Fixed PHP7 warnings
    - 4e0b313 2015-12-14 fixed PHP7 warnings (sol@hiqdev.com)
    - 4996078 2015-12-14 fixing PHP7 warnings (sol@hiqdev.com)
- Added phar compatibility
    - 5dee3f0 2015-12-14 + RUNDIR detection for phar (sol@hiqdev.com)
    - 3183775 2015-12-14 + box.json (sol@hiqdev.com)
- Fixed minii requirements
    - 2b908eb 2015-12-12 fixed minii requirements to stable (sol@hiqdev.com)
- Added `GitHubGoal`
    - 59ea763 2015-12-12 fixed github goal (sol@hiqdev.com)
    - fdad63e 2015-12-12 added GitHubGoal, it will NOT be separate (sol@hiqdev.com)
- Changed: separating `hidev-readme`
    - 4d4cc92 2015-12-12 improved readme badges templates (sol@hiqdev.com)

## 0.1.7 2015-12-04

- CHANGED: redone to `minii` and BROKEN build temporary
    - de5d98f 2015-12-02 fixed tests (sol@hiqdev.com)
    - 84f12c8 2015-12-02 used prepareExtensions (sol@hiqdev.com)
    - 073dc7a 2015-12-01 fixed ComposerJson::getFullName (sol@hiqdev.com)
    - b33cf78 2015-12-02 first working with minii (sol@hiqdev.com)
- Fixed badges generation
    - ca66d21 2015-12-03 fixed badges generation with Twig (sol@hiqdev.com)
    - c8d02f2 2015-11-24 removed junk template for gitignore (sol@hiqdev.com)
    - 1558eac 2015-11-24 fixed check for VersionEye badge (sol@hiqdev.com)
- Fixed vcsignoring implementation
    - 62a6737 2015-11-26 + test coverage reporting (sol@hiqdev.com)
    - b1833cc 2015-11-26 improved vcsignoring implementation (sol@hiqdev.com)
- Added exit code propagation and running commands facilities
    - da94efe 2015-11-24 + Application::runAction to not to corrupt exit status (sol@hiqdev.com)
    - 4d6ce1d 2015-11-23 + exit code propagation and running commands facilities: `passthru` and `get/detectBin` (sol@hiqdev.com)
    - 1c40e5c 2015-11-23 + functional test suite for phpunit (sol@hiqdev.com)
- Changed: license generation moved to `hidev-license` plugin
    - 3a19a38 2015-11-22 license generation moved to `hidev-license` plugin (sol@hiqdev.com)
    - daa3eb2 2015-11-12 + proprietary license (sol@hiqdev.com)
- Added `XmlHandler`
    - 69fedec 2015-11-23 added minimal example at File (sol@hiqdev.com)
    - 77dbdaa 2015-11-21 + `XmlHandler` for xml files (sol@hiqdev.com)
- Added PHPUnit integration with `hidev-phpunit` plugin
    - c7c632e 2015-11-24 fixed functional tests to work without Codeception (sol@hiqdev.com)
    - e3b0fc0 2015-11-22 improved package description (sol@hiqdev.com)
    - c668afe 2015-11-21 + phpunt.xml.dist (sol@hiqdev.com)
- Added Travis CI integration with `hidev-travis-ci` plugin
    - 6bcf138 2015-11-24 + Travis CI badge (sol@hiqdev.com)
    - 1f7fa85 2015-11-21 fixed check for VersionEye badge (sol@hiqdev.com)
    - 9036920 2015-11-21 improved checking hasRequire/Dev/Any (sol@hiqdev.com)
    - 9936b13 2015-11-20 trying travis (sol@hiqdev.com)
    - c79d8e5 2015-11-20 php-cs-fixed (sol@hiqdev.com)
    - 5cedb80 2015-11-20 fixed to `hiqdev\yii2\collection` namespace (sol@hiqdev.com)
    - 562e42a 2015-11-20 still doing travis plugin (sol@hiqdev.com)
    - 7ea638c 2015-11-19 fixing scrutinizer (sol@hiqdev.com)
    - b0179d6 2015-11-19 + travis allow failures for 7 and hhvm (sol@hiqdev.com)
    - 3a15706 2015-11-19 + .scrutinizer.yml (sol@hiqdev.com)
    - b11eae2 2015-11-19 debugging travis (sol@hiqdev.com)
    - b521bef 2015-11-19 + exception when cant run goal (sol@hiqdev.com)
    - 8259bc7 2015-11-19 trying travis (sol@hiqdev.com)
    - 76aae11 2015-11-19 trying travis (sol@hiqdev.com)
    - 61bb4b4 2015-11-19 + `ComposerJsonGoal::hasRequire/Dev/Any` (sol@hiqdev.com)
    - b186d89 2015-11-19 php-cs-fixed (sol@hiqdev.com)
    - 8de4839 2015-11-19 changed hidev modules require to get dev versions (sol@hiqdev.com)
    - e5f0713 2015-11-19 + uniqueConfig to remove duplicates from arrays in configs (sol@hiqdev.com)
- Added more options to init goal
    - 7049343 2015-11-18 + more options to init goal (sol@hiqdev.com)
- Fixed and improved tests and minor issues
    - c114e03 2015-11-18 fixed tests (sol@hiqdev.com)
    - fda72aa 2015-11-17 improved package description (sol@hiqdev.com)
    - 1541aa7 2015-11-15 fixed PackageGoal::defaultNamespace to be more strict (sol@hiqdev.com)
    - 7794937 2015-11-14 simplified package description processing (sol@hiqdev.com)
    - be32612 2015-11-12 simplified building LICENSE link (sol@hiqdev.com)
    - 65a9b07 2015-11-12 improved package headline processing (sol@hiqdev.com)
    - 31d0ba6 2015-11-12 improved generation of psr4 autoload config in composer.json (sol@hiqdev.com)

## 0.1.6 2015-11-09

- Fixed composer.json generation: follow schema, only name, role, email and homepage for authors
    - 85a0ff7 2015-11-09 fixed composer.json generation: follow schema, only name, role, email and homepage for authors (sol@hiqdev.com)

## 0.1.5 2015-11-09

- Added support for VCS ignoring list configuring in plugins
    - ce7ea96 2015-11-09 enabled php-cs-fixer caching (sol@hiqdev.com)
    - 91a543c 2015-11-09 added support for vcsignore list configuring in plugins (sol@hiqdev.com)

## 0.1.4 2015-11-09

- Fixed php short tags
    - 2bd5bc5 2015-11-09 php-cs-fixed (sol@hiqdev.com)
    - 3439892 2015-11-09 changed project title to: Task runner, code generator and build tool for easier continuos integration (sol@hiqdev.com)
    - 9d938de 2015-11-06 + nick and github to authors section in composer.json (sol@hiqdev.com)

## 0.1.3 2015-11-06

- Fixed 'hidev update' to do default procedure after updating
    - 6323f7c 2015-11-06 improved UpdateGoal to do default procedure after updating (sol@hiqdev.com)
- Changed README generation: added package headline
    - c544564 2015-11-06 Changed README generation: added package headline (sol@hiqdev.com)

## 0.1.2 2015-10-26

- Added basic Usage readme section
    - a533502 2015-10-26 + basic Usage readme section (sol@hiqdev.com)
- Added control of readme sections to be rendered
    - cdf01e7 2015-10-26 + control of readme sections to be rendered (sol@hiqdev.com)
- Added 'update' goal to update hidev internals
    - 68fb235 2015-10-26 + update goal (sol@hiqdev.com)

## 0.1.1 2015-10-25

- Added better badges configuring and rendering
    - cae13d3 2015-10-25 + github.version badge (sol@hiqdev.com)
    - c17149c 2015-10-25 fixed badges rendering (sol@hiqdev.com)
    - 7841c69 2015-10-24 + fixed badges configuring (sol@hiqdev.com)
- Fixed package title to: HiDev - integrated development
    - 7e900c3 2015-10-24 changed package title to: HiDev - integrated development (sol@hiqdev.com)
- Fixed getRepositoryUrl
    - 888674e 2015-10-24 fixed getRepositoryUrl (sol@hiqdev.com)

## 0.1.0 2015-10-15

- Added improved README generation with render functions and section templates
    - 25fa62d 2015-10-15 improved README generation with render functions and section templates (sol@hiqdev.com)
- Changed License section in README
    - 0bb0366 2015-10-05 fixed tests for new readme license section (sol@hiqdev.com)
    - 5bfde10 2015-10-05 changed License section in README (sol@hiqdev.com)
- Changed default config generated with 'hidev init': added authors and more options
    - cbe63ec 2015-10-06 improved 'hidev init' + authors section (sol@hiqdev.com)
    - cba9771 2015-10-05 fixed configuration readme for new 'hidev init' (sol@hiqdev.com)
    - adfd43e 2015-10-05 fixed tests for new features (sol@hiqdev.com)
    - f21e66d 2015-10-05 improved 'hidev init': + year and description options (sol@hiqdev.com)
- Added tests for README goal
    - 10f28b4 2015-10-05 php-cs-fixed (sol@hiqdev.com)
    - a96c530 2015-10-05 php-cs-fixed (sol@hiqdev.com)
    - a0ee0df 2015-10-05 + README minimal test (sol@hiqdev.com)
- Added tests for 'hidev init'
    - 397193c 2015-10-05 improved defaults for label, title and init (sol@hiqdev.com)
    - 3a01b0b 2015-10-05 fixed 'hidev init' to make type=project (sol@hiqdev.com)
    - c798edc 2015-10-04 + ReadmeGoalTest (sol@hiqdev.com)
    - 23d719a 2015-10-03 + functional/Tester.php (sol@hiqdev.com)
    - aa38c08 2015-09-21 + codeception gitignoring (sol@hiqdev.com)
    - f14cedb 2015-09-21 added basic tests for hidev init (sol@hiqdev.com)
- Fixed exception catching for proper showing user errors
    - 0f4634f 2015-09-20 fixed exception catching (sol@hiqdev.com)

## 0.0.10 2015-09-09

- Fixed init: made even smaller basic config
    - ec5b407 2015-09-09 fixed init: added conditional generation (sol@hiqdev.com)
- Fixed getting/setting namespace
    - f95fe40 2015-09-09 fixed getting/setting namespace (sol@hiqdev.com)

## 0.0.9 2015-09-08

- Added VersionEye badge generation
    - 64d022d 2015-09-08 fixed versioneye badge: dont show when no dependencies (sol@hiqdev.com)
    - 829f22b 2015-09-08 php-cs-fixed (sol@hiqdev.com)
    - cfe368f 2015-09-08 + VersionEye badge generation in ReadmeGoal (sol@hiqdev.com)
    - 687da1e 2015-09-08 + VersionEye badge (sol@hiqdev.com)
    - ee0043c 2015-09-08 docs (sol@hiqdev.com)
    - c96bec0 2015-09-08 docs (sol@hiqdev.com)
    - e573d4e 2015-09-08 docs (sol@hiqdev.com)
- Added showing user errors (instead of exception stack trace)
    - 7001f7e 2015-09-08 added showing user errors by catching exceptions caused by user mistakes (sol@hiqdev.com)
- Added init command: hidev init vendor/package
    - e90976f 2015-09-08 added init command (sol@hiqdev.com)
    - de455b9 2015-09-08 + DefaultGoal::options() for allowing to set public members with --option=value (sol@hiqdev.com)
    - f840ce3 2015-09-08 + Helper::getPublicVars, titleize (sol@hiqdev.com)
- Removed 'runtime' gitignoring by default
    - 4aa140b 2015-08-22 removed ignore runtime from VcsGoal (sol@hiqdev.com)

## 0.0.8 2015-08-17

- Added better README generation with badges and additional sections
    - 4918bc2 2015-08-17 + url license at README License Section (sol@hiqdev.com)
    - 81dca07 2015-08-17 + prefer source when getting .hidev deps (sol@hiqdev.com)
    - 3660961 2015-08-17 + 'include' configuration option (sol@hiqdev.com)
    - f34ccb8 2015-08-17 + LicenceGoal::getUrl() (sol@hiqdev.com)
    - ed8d93f 2015-08-17 + Helper::camel2id (sol@hiqdev.com)
    - 5798ab8 2015-08-17 Update README.md (sol@hiqdev.com)
    - 144715e 2015-08-17 + better README generation (sol@hiqdev.com)
    - 1e1ef93 2015-08-17 + better README generation (sol@hiqdev.com)
- Added runAction/s
    - e5c212f 2015-07-28 + runAction/s with isDone check to run once (sol@hiqdev.com)
- Changed determining done
    - f7dc1ee 2015-07-19 * determining done: + is/markDone (sol@hiqdev.com)
- Fixed minor bugs
    - bf13b89 2015-08-17 + better description (sol@hiqdev.com)
    - f4a8f5b 2015-07-19 fixed setting deps at CommitsGoal (sol@hiqdev.com)
    - 675fa1b 2015-07-19 simplified ChangelogHandler::parse/render (sol@hiqdev.com)
    - 8ea5658 2015-07-19 - old junk debug from BaseHandler::parsePath (sol@hiqdev.com)
    - 46c110b 2015-07-18 minor fixes (sol@hiqdev.com)
- Changed .gitignore generation, now built from hashmap with comments
    - 52733f9 2015-07-12 improved .gitignore generation (sol@hiqdev.com)
    - 8600bf1 2015-07-12 + .gitignore smart generation (sol@hiqdev.com)
- Changed config: redone parent with plugins
    - c7fcc13 2015-07-12 fixed require at .hidev/config (sol@hiqdev.com)
    - 9524e62 2015-07-11 php-cs-fixed (sol@hiqdev.com)
    - 0c1619f 2015-07-11 * .hidev/config require to hidev-config-php only (sol@hiqdev.com)
    - 00d2fdf 2015-07-11 * initing: + create .hidev/vendor if not exists (sol@hiqdev.com)
    - dd5132a 2015-07-10 - run local hidev (sol@hiqdev.com)
    - 62c053e 2015-07-10 commits moved back to .hidev/commits.md (sol@hiqdev.com)
    - 8899ef1 2015-07-10 + Application::bootstrap() to load .hidev/vendor (sol@hiqdev.com)
    - 613e134 2015-07-10 redoing to .hidev/vendor (sol@hiqdev.com)
    - af65f57 2015-07-09 warning Running the file (sol@hiqdev.com)
    - cf2dd97 2015-07-09 improved initialization: + try ./bin/hidev (sol@hiqdev.com)
    - 496217f 2015-07-09 * composer.json generation: require-dev (sol@hiqdev.com)
    - 40b52c1 2015-07-09 improved running local bin (sol@hiqdev.com)
    - ab0ecae 2015-07-09 improved initialization, + localbin execution (sol@hiqdev.com)
    - 1d5fb22 2015-07-09 still redoing parent to plugins (sol@hiqdev.com)
    - 317f58c 2015-07-09 improved initialization (sol@hiqdev.com)
    - 212d220 2015-07-09 * CommitsHandler::renderDate minor fix (sol@hiqdev.com)
    - 445d4df 2015-07-08 php-cs-fixed (sol@hiqdev.com)
    - 57c98f1 2015-07-07 + require-dev (sol@hiqdev.com)
    - 327628e 2015-07-07 redone all initialization for pluggable parent config (sol@hiqdev.com)
    - 26f3f1e 2015-07-07 - AuthorGoal (sol@hiqdev.com)
- Changed source dir: moved to src
    - 39754c6 2015-07-09 great moving to src dir (sol@hiqdev.com)
- Added initial Getting started doc
    - 62c158d 2015-07-11 docs (sol@hiqdev.com)
    - 48b75d3 2015-07-10 * docs/GettingStarted.md (sol@hiqdev.com)
    - e06aa69 2015-07-04 Update GettingStarted.md (sol@hiqdev.com)
    - 13540c0 2015-07-04 Create GettingStarted.md (sol@hiqdev.com)
    - a4f2874 2015-07-05 Update GettingStarted.md (sol@hiqdev.com)
    - c7f0349 2015-07-05 Update GettingStarted.md (sol@hiqdev.com)
- Changed change log to follow keepachangelog.com recomendations
    - 1c354e3 2015-07-04 Changed change log to follow keepachangelog.com recomendations (sol@hiqdev.com)
    - 0610949 2015-07-04 added docs/BestPractices.md (sol@hiqdev.com)
    - 15e02ae 2015-07-04 changed CommitsHandler::renderDate for ISO date formatting (sol@hiqdev.com)
    - caa6c7f 2015-07-04 Update CHANGELOG.md (sol@hiqdev.com)
    - 98ee9c9 2015-07-04 Update CHANGELOG.md (sol@hiqdev.com)
- Changed roadmap
    - 2df0c08 2015-07-12 * ROADMAP (sol@hiqdev.com)
    - 918838a 2015-07-12 * ROADMAP (sol@hiqdev.com)
    - 3ab4873 2015-07-11 * ROADMAP (sol@hiqdev.com)
    - 0933afb 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - 41012fc 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - 5121836 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - b4d975a 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - 0330b4b 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - 38a2637 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - 7407b96 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - d6d02d7 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
    - 8e45be6 2015-07-04 Update ROADMAP.md (sol@hiqdev.com)
- Added tests
    - 180477e 2015-06-30 + codeception.yml (sol@hiqdev.com)
- Added generate goal: generate file by template and params
    - 2235ef0 2015-07-03 * TemplateHandler: + pass file to template (sol@hiqdev.com)
    - 9de9f43 2015-06-30 + generate/mkdir action (sol@hiqdev.com)
    - 34d8231 2015-06-29 + GenerateGoal (sol@hiqdev.com)
    - 9e9784f 2015-06-29 small but good fix to extend from console\Controller <- base\Controller (sol@hiqdev.com)
- Added codeception plugin
    - 233d4be 2015-06-28 redone goals name -> goalName (sol@hiqdev.com)
    - e731acd 2015-06-28 crutched yaml rendering (sol@hiqdev.com)
    - 055defb 2015-06-28 + require plugins hidev-codeception/php-cs-fixer (sol@hiqdev.com)
- Changed config loading
    - e26d2b5 2015-06-27 redone File/Goal::exists (sol@hiqdev.com)
    - 76546e7 2015-06-27 * .hidev/config.yml: - composer.json config goes to composer.json (sol@hiqdev.com)
    - 1384678 2015-06-27 improved actionLoad in base/File and ComposerJsonGoal (sol@hiqdev.com)
    - f8996bc 2015-06-27 used `module->runAction` at actionDeps (sol@hiqdev.com)
    - e4882d4 2015-06-27 * ComposerJsonGoal + standart load (sol@hiqdev.com)
- Changed: redone goals like controllers
    - a0b4883 2015-07-11 removed old controllers/DefaultController (sol@hiqdev.com)
    - ed7537c 2015-06-30 + Application::runRequest (sol@hiqdev.com)
    - 37d11fa 2015-06-26 renamed actions to actionPerform/Make/... (sol@hiqdev.com)
    - c069025 2015-06-26 + parent/update action (sol@hiqdev.com)
    - cdcf25f 2015-06-24 php-cs-fixed (sol@hiqdev.com)
    - c4d8a63 2015-06-24 + getting default goal (sol@hiqdev.com)
    - 0888788 2015-06-24 redoing goals like controllers (sol@hiqdev.com)
    - bf724ab 2015-06-23 changelog (sol@hiqdev.com)
    - 32be392 2015-06-23 * roadmap (sol@hiqdev.com)

## 0.0.7 2015-06-19

- Changed composer.json: dont add empty require
    - fd344b8 2015-06-19 + delete require if empty (sol@hiqdev.com)
- Fixed code styling with php-cs-fixer
    - 9605650 2015-06-19 php-cs-fixed (sol@hiqdev.com)
- Added php-cs-fixer plugin
    - c87d8c7 2015-06-18 php-cs-fixing (sol@hiqdev.com)
    - af2097f 2015-06-18 + Helper::asplit (sol@hiqdev.com)
    - c71aa85 2015-06-18 - views/CHANGELOG.php cause it is not needed anymore (sol@hiqdev.com)
    - 7b79e7a 2015-06-18 php-cs-fixed (sol@hiqdev.com)
    - e155570 2015-06-18 + `Twig_Extension_StringLoader` for `template_from_string` (sol@hiqdev.com)
    - 8de7066 2015-06-18 php-cs-fixing (sol@hiqdev.com)
    - 492d5c3 2015-06-18 php-cs-fixing (sol@hiqdev.com)
    - 8eaa43f 2015-06-18 improving `.php_cs` (sol@hiqdev.com)
    - 67c5255 2015-06-17 inited `.php_cs` (sol@hiqdev.com)
- Added plugin archtecture
    - 26c9579 2015-06-17 doing plugin architecture (sol@hiqdev.com)
    - 7bacafa 2015-06-14 + skip Merge branch commits (sol@hiqdev.com)
- Fixed portability
    - 5350f2e 2015-06-14 improved portability (sol@hiqdev.com)
    - d48c5a1 2015-06-09 fixed adding new commits (sol@hiqdev.com)
    - 71a04c5 2015-06-09 * default package homepage to same as source (sol@hiqdev.com)
    - 0bca3e0 2015-06-07 small fixes (sol@hiqdev.com)

## 0.0.6 June 6, 2015

- Changed: GREAT RENAMING OF CLASSES
    - a9aed7b 2015-06-06 improved title, description, forum options at package/vendor (sol@hiqdev.com)
    - 3091450 2015-06-06 GREAT RENAMING OF CLASSES (sol@hiqdev.com)
- Added cool CHANGELOG.md generation
    - 75326d1 2015-06-06 fixed adding Under development tag (sol@hiqdev.com)
    - b7f0f9f 2015-06-05 improved skip minor (sol@hiqdev.com)
    - 3475a27 2015-06-05 rendering commits fixed (sol@hiqdev.com)
    - 8546f09 2015-06-05 + skip 'minor' commits at addHistory (sol@hiqdev.com)
    - 5474d01 2015-06-05 + handlers\Commits::renderLines (sol@hiqdev.com)
    - 54cf1f5 2015-06-05 + cool CHANGELOG.md generation (sol@hiqdev.com)
    - 8e6c700 2015-06-04 * default make for goals to load&save (sol@hiqdev.com)
    - 4af195c 2015-06-03 + getVcs() at base goal (sol@hiqdev.com)
    - 3ced3b8 2015-06-03 minor:roadmap (sol@hiqdev.com)
    - a23782b 2015-06-03 minor:commits (sol@hiqdev.com)
    - 569e582 2015-06-03 minor:commits (sol@hiqdev.com)
    - 133d4d4 2015-06-03 minor (sol@hiqdev.com)
    - 57a5beb 2015-06-03 Update commits.md (sol@hiqdev.com)
    - 1f5a9c3 2015-06-03 Update commits.md (sol@hiqdev.com)
    - 102434a 2015-06-03 Update commits.md (sol@hiqdev.com)
    - 7d8f7d1 2015-06-03 + .hidev/commits.md (sol@hiqdev.com)
- Added gen action to generate files by templates
    - feb986e 2015-06-02 + gen action to generate files by templates, changed way of looking for templates (sol@hiqdev.com)
- Added "No licence" default license
    - 1bfbeec 2015-06-02 + default license from vendor, + No license (sol@hiqdev.com)
    - 4a851f3 2015-06-01 * roadmap (sol@hiqdev.com)

## 0.0.5 June 1, 2015

- Changed decreased default verbosity
    - 5d56e27 2015-06-01 Decreased verbosity (sol@hiqdev.com)
    - dbc04c9 2015-06-01 fixed parent config cloning (sol@hiqdev.com)

## 0.0.4 June 1, 2015

- Added twig templates
    - 4078ac2 2015-06-01 BIG + twig (sol@hiqdev.com)

## 0.0.3 June 1, 2015

- Added YAML config
    - b80e4d4 2015-06-01 BIG + YAML, used for config (sol@hiqdev.com)
- Added ROADMAP.md
    - 13f6f30 2015-05-31 + ROADMAP.md (sol@hiqdev.com)

## 0.0.2 May 30, 2015

- Added parent config
    - 1182cdc 2015-05-30 + ignore .hidev/parent (sol@hiqdev.com)
- Added use of Robo (started robo integration)
- Changed namespace to 'hidev'
    - ed742a4 2015-05-30 HUGE + parent config HUGE * namespace beginned + Robo (sol@hiqdev.com)
    - 7817ae0 2015-05-29 added and used package.namespace for composer.json autoload used package/vendor instead of config->package/vendor (sol@hiqdev.com)
- Fixed different minor thing
    - 43150ff 2015-05-17 minor (sol@hiqdev.com)
    - de9f755 2015-05-16 * keywords (sol@hiqdev.com)
    - cf53e9a 2015-05-16 + default package description and homepage from vendor homepage (sol@hiqdev.com)
    - c8b508d 2015-05-15 * forum (sol@hiqdev.com)
    - 493da06 2015-05-15 + fullName, source getters (sol@hiqdev.com)
    - 6eb4fc4 2015-05-15 fixed (sol@hiqdev.com)
    - acd98f5 2015-05-14 renamed rawItem <- getRaw (sol@hiqdev.com)
    - a669a77 2015-05-14 - `Config::_defaults` (sol@hiqdev.com)
    - 8470ddc 2015-05-14 * composer requires to yii2 stable not dev (sol@hiqdev.com)

## 0.0.1 May 12, 2015

- Added basics
- Added colorized console output
    - 98d97df 2015-05-12 + styled Console log output (sol@hiqdev.com)
    - 8813192 2015-05-12 simplified a bit, removed excessive set functions whose work is done automatically (sol@hiqdev.com)
    - d5968d9 2015-05-07 + own Application, Request + alises (sol@hiqdev.com)
    - a1d4db1 2015-05-05 minor (sol@hiqdev.com)
    - d9ad2cc 2015-05-04 + Application, ViewContext move into it from Config (sol@hiqdev.com)
    - bece54c 2015-05-04 minor (sol@hiqdev.com)
    - 09fb3b4 2015-05-04 redone to deps looks goog now (sol@hiqdev.com)
- Added README.md generation
- Added CHANGELOG.md generation
    - cf4564b 2015-05-02 MINIMUM DONE. URA (sol@hiqdev.com)
    - 303ac77 2015-05-02 rename homepage <- site (sol@hiqdev.com)
    - 9d801b9 2015-05-02 fixed: no comments after pattern (sol@hiqdev.com)
    - 67fbd14 2015-05-02 fixed: no comments after pattern (sol@hiqdev.com)
- Added composer.json generation
    - 4c5554e 2015-05-02 doing composer.json goal (sol@hiqdev.com)
    - 3101c68 2015-05-02 doing composer.json goal (sol@hiqdev.com)
- Added simple .gitignore generation
    - 006a0ab 2015-04-30 + .gitignore (sol@hiqdev.com)
    - 7675d1c 2015-04-30 + templates looking in .hidev/templates (sol@hiqdev.com)
- Added LICENSE generation
    - ad8d8d0 2015-04-30 improving LICENSE (sol@hiqdev.com)
    - e4b5cd2 2015-04-30 GREAT move ahead: now making LICENSE :) (sol@hiqdev.com)
    - 04777ec 2015-04-28 inited (sol@hiqdev.com)

## Development started April 28, 2015


ROADMAP
-------

### 0.2.0

- travis
- scrutinizer
- codeception plugin: generate basic tests
- tests for: init, .gitignore, composer.json, LICENSE
- interpolate $variables in config
- robo plugin: run goals from Robo
- before/after options
- status/install/update super goals: run status/install/update action on every goal that has it

### 0.3.0

- change $done to hold timestamp of goal completion and use it to determine if goal needs to be done

### 1.0.0

- phpunit plugin
- other build tools integration grunt, gulp, make,  phing, phake plugins: run & load goals
- CI tools integration: Jenkins, TeamCity

### Refactoring

- generalization for composer, git, testing
  - PackageManagerGoal or PmGoal
  - VersionControlGoal or VcsGoal, VcsIgnoreGoal
- redo CommitsHandler to History component
- rewrite without yii?

### General goals

- **Package management**: composer.json, Packagist
- **Release automation**: README, LICENSE, CHANGELOG, CONTRIBUTING
- **Code generation**: php, twig, smarty
- **Documentation**: github wiki, apidoc, phpdoc
- **Development tools**: swager
- **Build tools**: robo, grunt, phing, phake, make, ...
- **VCS**: .gitignore, github, commits history
- **Code quality**: php-cs-fixer, phpcs, Scrutinizer, Insight, CodeClimate, VersionEye
- **Testing**: codeception, phpunit, Coveralls
- **CI**: Travis, Jenkins, TeamCity, AppVeyor


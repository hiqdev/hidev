The main idea behind HiDev is to combine code generator and build tool to stop
copying config files between your projects. And automate all the repeated tasks
of course. But firstly generate all the files that can be generated, e.g.:

- `.gitignore`, `README.md`, `LICENSE`, `CHANGELOG.md`
- `composer.json`
- `.travis.yml`, `.scrutinizer.yml`
- `phpunit.xml`, `codeception.yml`
- `.php_cs`

You write a simple config specifying general information about your package
and plugins to be used. HiDev alone does nothing at all! You specify what
you want it to do in config or use plugins. There are predefined plugins with
generally usable configs or you can create plugins yourself.

For example, `hiqdev/hidev-php` plugin is a general config for PHP projects and
will enable HiDev to create all the listed above files and adds goals to use:

- `hidev default` or simply `hidev` will update config files according to the changes you made
- `hidev fix`: will update `.php_cs` file and run `php-cs-fixer` to fix code style of your PHP files
- `hidev test`: will update `phpunit.xml` and run your tests with `phpunit`
- `hidev build`: will do fix and test alltogether
- `hidev bump` and `hidev release` will bump project version and publish release to GitHub

HiDev can generate different files: sources, tests, anything else based on templates and
all the information available in config files or elsewhere.

Now I'm working to enable HiDev to do more:

- project bootstraping and deploy
- integration with other build tools: robo, grunt, gulp, ...
- more for Python: pep8, tests, ...


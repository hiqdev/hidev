Standart goals
==============

init

start
    # chdir to project root
    # load project extensions

plugins

binaries

install: start
    composer/install

update: start
    composer/update

build: install
    fix
    test
    phar/build

publish: build

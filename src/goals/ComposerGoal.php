<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

/**
 * Goal for Composer.
 */
class ComposerGoal extends DefaultGoal
{
    public function init()
    {
        parent::init();
        $this->setDeps('composer.json');
        $this->vcs->setIgnore([
            'vendor'        => 'vendor dirs',
            'composer.lock' => 'composer lock files',
        ], 'first');
    }

    public function getNamespace()
    {
        $this->config->get('composer.json')->actionLoad();

        return @trim(key($this->config->get('composer.json')->getFile()->get('autoload')['psr-4']), '\\');
    }
    public function getConfigFile()
    {
        $conf = parent::getConfig()->get('composer.json');
        $conf->runAction('load');
        return $conf;
    }
}

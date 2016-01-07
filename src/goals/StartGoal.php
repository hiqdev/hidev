<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Goal that starts ...
 */
class StartGoal extends DefaultGoal
{
    public function actionPerform()
    {
        Yii::setAlias('@prjdir', $this->findDir());
        $this->loadExtensions();
    }

    protected function loadExtensions()
    {
            $require = Yii::createObject([
                'class' => 'hidev\base\File',
                'path'  => '.hidev/config.yml',
            ])->load()['require'];
            if ($require) {
                Yii::createObject([
                    'class' => 'hidev\base\File',
                    'path'  => '.hidev/composer.json',
                ])->save(compact('require'));
                if (!is_dir('.hidev/vendor')) {
                    exec('cd .hidev;composer update --prefer-source');
                }
                $main  = Yii::getAlias('@vendor');
                $local = realpath('./.hidev/vendor');
                if ($local !== $main) {
                    $this->extensions = array_merge(
                        $this->prepareExtensions($main),
                        $this->prepareExtensions($local)
                    );
                }
            }
    }

    /**
     * Looks for config file in the current directory and up.
     * @return string path to the root directory of hidev project
     * @throws InvalidConfigException when failed to find
     */
    protected function findDir()
    {
        $configDir = '.hidev';
        if (!$isInit) {
            for ($i = 0;$i < 9;++$i) {
                if (is_dir($configDir)) {
                    return getcwd();
                }
                chdir('..');
            }
        }
        throw new InvalidConfigException('Not a hidev project (or any of the parent directories). Use `hidev init` to initialize hidev project.');
    }
}

<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use hidev\base\File;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Start goal.
 * Chdirs to the project's root directory and loads dependencies and configs.
 */
class StartController extends CommonController
{
    const MAIN_CONFIG = '.hidev/config.yml';

    public static $started = false;

    public function actionMake()
    {
        Yii::setAlias('@prjdir', $this->findDir());
        $this->takeConfig()->includeConfig(static::MAIN_CONFIG);
        $this->requireAll();
        $this->includeAll();
        self::$started = true;
    }

    protected function requireAll()
    {
        $require = $this->takeConfig()->rawItem('require');
        if ($require) {
            $require['hiqdev/composer-extension-plugin'] = '*@dev';
            $saved = File::create('.hidev/composer.json')->save(compact('require'));
            if ($saved || !is_dir('.hidev/vendor')) {
                $this->takeGoal('update')->makeUpdate();
            }
            /// backup config then reset with extra config then restore
            $config = $this->takeConfig()->getItems();
            Yii::$app->clear('config');
            Yii::$app->loadExtraVendor('.hidev/vendor');
            $this->takeConfig()->mergeItems($config);
        }
    }

    /**
     * Include all configs.
     * @return void
     */
    public function includeAll()
    {
        $still = true;
        while ($still) {
            $still = false;
            $include = $this->takeConfig()->rawItem('include');
            if ($include) {
                foreach ($include as $path) {
                    $still = $still || $this->takeConfig()->includeConfig($path);
                }
            }
        }
    }

    /**
     * Chdirs to project's root by looking for config file in the current directory and up.
     * @throws InvalidConfigException when failed to find
     * @return string path to the root directory of hidev project
     */
    protected function findDir()
    {
        $configDir = '.hidev';
        for ($i = 0;$i < 9;++$i) {
            if (is_dir($configDir)) {
                return getcwd();
            }
            chdir('..');
        }
        throw new InvalidConfigException('Not a hidev project (or any of the parent directories). Use `hidev init` to initialize hidev project.');
    }
}

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
 * Install goal.
 */
class InstallGoal extends DefaultGoal
{
    public function actionMake()
    {
        Yii::warning('install');
    }

    public function actionUpdate()
    {
        exec('cd .hidev;composer update --prefer-source');
        $this->module->runRequest('');
    }

    protected $_bins;

    public function getBin($prog)
    {
        if ($this->_bins[$prog] === null) {
            $this->_bins[$prog] = $this->detectBin($prog);
        }

        return $this->_bins[$prog];
    }

    /**
     * Detects how to run given prog.
     * Searches in this order:
     * 1. prog.phar in project root directory
     * 2. ./vendor/bin/prog
     * 3. $HOME/.composer/vendor/bin/prog
     * 4. `which $prog`.
     *
     * @param string $prog
     * @return string path to the binary prepended with `env php` when found file is not executable
     */
    public function detectBin($prog)
    {
        /*
        $pkg = $this->getItem('bin')[$prog];
        if (!$pkg) {
            throw new InvalidConfigException("Unknown bin: $prog");
        }
        $path = $this->package->hasRequireAny($pkg) ? './vendor/bin' : '$HOME/.composer/vendor/bin';
        */

        $paths = [Yii::getAlias("@source/$prog.phar"), Yii::getAlias("@source/vendor/bin/$prog"), "$_SERVER[HOME]/.composer/vendor/bin/$prog"];
        foreach ($paths as $path) {
            if (file_exists($path)) {
                return is_executable($path) ? $path : 'env php ' . $path;
            }
        }

        $path = exec('which ' . $prog);
        if ($path) {
            return $prog;
        }

        throw new InvalidConfigException("Failed to find how to run $prog");
    }
}

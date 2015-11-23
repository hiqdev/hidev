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

use Yii;
use yii\base\InvalidConfigException;

/**
 * Update goal.
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

    public function detectBin($prog)
    {
        $pkg = $this->getItem('bin')[$prog];
        if (!$pkg) {
            throw new InvalidConfigException("Unknown bin: $prog");
        }
        $path = $this->package->hasRequireAny($pkg) ? './vendor/bin' : '$HOME/.composer/vendor/bin';

        return $path . DIRECTORY_SEPARATOR . $prog;
    }
}

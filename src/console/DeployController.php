<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\console;

use hidev\components\Deployer;

/**
 * Deploy Controller.
 * TODO REDO the whole thing to be configurable
 */
class DeployController extends CommonController
{
    public $defaultAction = 'all';

    public function actionAll($name = null, $command = 'all')
    {
        $deployer = new Deployer($name);

        return $deployer->call($command);
    }
}

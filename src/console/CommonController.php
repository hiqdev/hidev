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

use Yii;

/**
 * Common controller.
 */
class CommonController extends \hidev\base\Controller
{
    use \hiqdev\yii2\collection\ManagerTrait;

    public function actionIndex()
    {
        Yii::debug("Started: '$this->id'");
    }

    public function actions()
    {
        $actions = [];
        foreach ($this->keys() as $name) {
            $actions[$name] = ['class' => CommonAction::class];
        }

        return $actions;
    }
}

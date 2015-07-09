<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\controllers;

use Yii;
use yii\helpers\Inflector;

/**
 * Generate class API documentation.
 */
class DefaultController extends \yii\console\Controller
{
    /**
     * Check has action.
     */
    public static function hasAction($id)
    {
        return method_exists(get_called_class(), 'action' . Inflector::id2camel($id));
    }

    /**
     * The main command: do the magic!
     */
    public function actionIndex()
    {
        Yii::$app->config->run();

        return 0;
    }

    /**
     * Run the goal.
     */
    public function actionRun($goal)
    {
        if (!Yii::$app->config->hasItem($goal)) {
            d("Can't run goal '$goal'");
        }
        Yii::$app->config->getItem($goal)->run();

        return 0;
    }

    /**
     * Generate by template.
     */
    public function actionGen($tpl, $file = null)
    {
        $gen = Yii::createObject([
            'class'    => 'hidev\goals\TemplateGoal',
            'template' => $tpl,
            'file'     => $file ?: (basename($tpl) . '.php'),
        ]);
        $gen->save();

        return 0;
    }

    /**
     * The grep command.
     */
    public function actionGrep()
    {
        d('HERE AT grep');

        return 0;
    }
}

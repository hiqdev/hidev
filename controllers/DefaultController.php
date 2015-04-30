<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev 
 */

namespace hiqdev\hidev\controllers;

use Yii;

/**
 * Generate class API documentation.
 */
class DefaultController extends \yii\console\Controller
{

    /**
     * The main command: do the magic!
     */
    public function actionIndex()
    {
        Yii::$app->config->all->run();
        return 0;
    }
}

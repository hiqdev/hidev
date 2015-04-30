<?php

namespace hiqdev\hidev\components;

use Yii;

/**
 * Our View.
 * Redefined for extending.
 */
class View extends \yii\web\View
{

    public function getConfig()
    {
        return Yii::$app->config;
    }
}

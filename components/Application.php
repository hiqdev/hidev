<?php

namespace hiqdev\hidev\components;

use Yii;
use yii\base\ViewContextInterface;

/**
 * The Application.
 * Redefined for extending.
 */
class Application extends \yii\console\Application implements ViewContextInterface
{
    protected $_viewPath;

    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = Yii::$app->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }

        return $this->_viewPath;
    }
}

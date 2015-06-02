<?php

namespace hidev\components;

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
            $this->_viewPath = Yii::getAlias('@parent/templates');
        }

        return $this->_viewPath;
    }
}

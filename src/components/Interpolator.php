<?php

namespace hidev\components;

use Yii;
use yii\helpers\ArrayHelper;

class Interpolator
{
    public function interpolate(&$data)
    {
        if (is_array($data)) {
            foreach ($data as &$item) {
                $this->interpolate($item);
            }
        } elseif (is_string($data)) {
            $data = preg_replace_callback('/\{{ (.*?) }}/', function ($matches) {
                return $this->get($matches[1]);
            }, $data);
        }
    }

    public function get($name)
    {
        list($scope, $subname) = explode('.', $name, 2);

        if ($scope === 'params') {
            return Yii::$app->params[$subname];
        } elseif ($scope === 'config') {
            return $this->getConfig($subname);
        } else {
            return $this->getConfig($name);
        }
    }

    public function getConfig($name)
    {
        list($goal, $subname) = explode('.', $name, 2);

        return ArrayHelper::getValue(Yii::$app->get('config')->getGoal($goal), $subname);
    }
}

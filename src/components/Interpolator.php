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
            $data = preg_replace_callback('/\\$(\\w+)\\[\'(.+?)\'\\]/', function ($matches) {
                return $this->get($matches[1], $matches[2]);
            }, $data);
        }
    }

    public function get($scope, $name)
    {
        if ($scope === 'params') {
            return Yii::$app->params[$name];
        } elseif ($scope === 'config') {
            return $this->getConfig($name);
        } else {
            return "\$${scope}['$name']";
        }
    }

    public function getConfig($name)
    {
        list($goal, $subname) = explode('.', $name, 2);

        return ArrayHelper::getValue(Yii::$app->get('config')->getGoal($goal), $subname);
    }
}

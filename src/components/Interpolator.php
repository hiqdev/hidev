<?php

namespace hidev\components;

use Yii;

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
        } else {
            return null;
        }
    }
}

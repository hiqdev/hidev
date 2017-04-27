<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

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
        } elseif ($scope === '_ENV') {
            return $_ENV[$name];
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

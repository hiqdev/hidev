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

/**
 * Interpolates array recursively.
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class Interpolator
{
    public $data;

    public function interpolate(&$data)
    {
        $this->data = &$data;
        $this->interpolateArray($data);
    }

    private function interpolateArray(&$data)
    {
        if (is_array($data)) {
            foreach ($data as &$item) {
                $this->interpolateArray($item);
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
            return $this->data['params'][$name];
        } elseif ($scope === '_ENV') {
            return $_ENV[$name];
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

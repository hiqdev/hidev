<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Handler for YAML files.
 */
class YamlHandler extends TypeHandler
{
    /**
     * {@inheritdoc}
     */
    public function renderType($data)
    {
        /// XXX TODO fix getItems crutch
        return Yaml::dump(ArrayHelper::toArray(method_exists($data, 'getItems') ? $data->getItems() : $data), 4);
    }

    /**
     * {@inheritdoc}
     */
    public function parse($yaml)
    {
        $data = (array) Yaml::parse($yaml);
        $this->interpolateParams($data);

        return $data;
    }

    public function interpolateParams(&$data)
    {
        if (is_array($data)) {
            foreach ($data as &$item) {
                $this->interpolateParams($item);
            }
        } elseif (is_string($data)) {
            $data = preg_replace_callback('/\$params\[\'(.*?)\'\]/', function ($matches) {
                return Yii::$app->params[$matches[1]];
            }, $data);
        }
    }
}

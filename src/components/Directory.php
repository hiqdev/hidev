<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use hidev\helpers\FileHelper;
use Yii;

/**
 * Directory manipulation component.
 */
class Directory extends File
{
    public function save()
    {
        if (!file_exists($this->path)) {
            FileHelper::mkdir($this->path);
        }

        foreach ($this->getItems() as $id => $config) {
            $type = isset($config['template']) || isset($config['copy']) ? 'File' : 'Directory';
            $defaults = [
                'class' => "hidev\\components\\$type",
                'path'  => $this->path . '/' . $id,
            ];
            $config = array_merge($defaults, $config ?: []);
            $object = Yii::createObject($config);
            $object->save();
        }

        $this->modifyFile();
    }
}

<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
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
        FileHelper::mkdir($this->_path);

        foreach ($this->getItems() as $id => $config) {
            $type = 'Directory';
            if (isset($config['template']) || isset($config['copy'])) {
                $type = 'File';
            } elseif (isset($config['symlink'])) {
                $type = 'Symlink';
            }
            $defaults = [
                'class' => "hidev\\components\\$type",
                'path' => $this->_path . '/' . $id,
            ];
            $config = array_merge($defaults, $config ?: []);
            $object = Yii::createObject($config);
            $object->save();
        }

        $this->modifyFile();
    }

    public function load()
    {
    }
}

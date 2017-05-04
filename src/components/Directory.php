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

use hidev\helpers\FileHelper;

/**
 * Directory manipulation component.
 */
class Directory extends \yii\base\Object
{
    public $recursive = [];

    public function save()
    {
        if (!file_exists($this->path)) {
            FileHelper::mrkdir($this->path);
        }
        foreach ($this->getItems() as $id => $config) {
            $defaults = [
                'class' => isset($config['template']) || isset($config['copy']) ? 'template' : 'directory',
                'file'  => $this->path . '/' . $id,
            ];
            if ($this->recursive) {
                $defaults['recursive'] = $this->recursive;
                foreach ((array) $this->recursive as $key) {
                    if ($this->{$key}) {
                        $defaults[$key] = $this->{$key};
                    }
                }
            }
            $goal = $this->takeConfig()->createItem($id, array_merge($defaults, $config ?: []));
            $goal->perform();
        }
    }
}

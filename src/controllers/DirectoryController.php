<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Yii;

/**
 * Directory controller.
 */
class DirectoryController extends FileController
{
    public $recursive = [];

    /**
     * Load action.
     */
    public function actionLoad()
    {
        /// nothing for the moment
    }

    public function hasPath()
    {
        return $this->_file || $this->_path;
    }

    public function actionSave()
    {
        if (!file_exists($this->path)) {
            $this->mkdir($this->path);
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

    public function mkdir($path)
    {
        Yii::warning('mkdir ' . $path, 'dir');
        mkdir($path);
    }
}

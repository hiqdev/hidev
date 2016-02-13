<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
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
    /**
     * Load action.
     * @return void
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
                'class' => 'directory',
                'file'  => $this->path . '/' . $id,
            ];
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

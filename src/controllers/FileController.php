<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use hidev\base\File;
use hidev\helpers\Helper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * File controller.
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class FileController extends CollectionController
{
    /**
     * {@inheritdoc}
     */
    protected $_make = ['load', 'save', 'modify'];

    /**
     * @var string specifies handler to be used
     */
    public $fileType;

    /**
     * @var bool Don't touch file if exists
     */
    public $once;

    /**
     * @var string Username to change file owner to
     */
    public $chown;

    /**
     * @var string Group to change file group to
     */
    public $chgrp;

    /**
     * @var string|integer Permissions to change to
     */
    public $chmod;

    /**
     * @var array|File the file to be handled
     */
    protected $_file;

    /**
     * @var string path to copy from
     */
    protected $_copy;

    /**
     * @var string the path to the file
     */
    protected $_path;

    /**
     * @var string the template name
     */
    protected $_template;

    /**
     * Template setter.
     * @param string $template name
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * Template getter.
     */
    public function getTemplate()
    {
        return Helper::file2template($this->_template ?: $this->id);
    }

    /**
     * Returns the file object.
     * Instantiates it if necessary.
     *
     * @return File
     */
    public function getFile()
    {
        if (!is_object($this->_file)) {
            $this->_file = Yii::createObject(array_merge([
                'class'    => File::class,
                'template' => $this->getTemplate(),
                'goal'     => $this,
                'path'     => $this->_path ?: $this->id,
            ], is_string($this->_file)
                ? ['path' => $this->_file]
                : (array) $this->_file
            ));
        }

        return $this->_file;
    }

    /**
     * Sets file with given info.
     * @param mixed $info could be anything that is good for File::create
     */
    public function setFile($info)
    {
        $this->_file = $info;
    }

    /**
     * Sets the path to the file, but file info has precendence.
     * @param string $value
     */
    public function setPath($value)
    {
        $this->_path = $value;
    }

    /**
     * Copy setter. Turns this file type to `copy`.
     */
    public function setCopy($value)
    {
        $this->fileType = 'copy';
        $this->_copy = $value;
    }

    /**
     * Copy getter. Processes aliases.
     */
    public function getCopy()
    {
        return Yii::getAlias($this->_copy);
    }

    /**
     * Dirname getter.
     */
    public function getDirname()
    {
        return $this->getFile()->getDirname();
    }

    /**
     * Path getter.
     */
    public function getPath()
    {
        return $this->getFile()->getPath();
    }

    /**
     * Checks if the file exists.
     */
    public function exists()
    {
        return $this->getFile()->exists();
    }

    /**
     * Read the file.
     */
    public function read()
    {
        return $this->getFile()->read();
    }

    /**
     * Read the file into array.
     * @return array
     */
    public function readArray()
    {
        return $this->getFile()->readArray();
    }

    /**
     * {@inheritdoc}
     */
    public function actionPerform($name = null, $path = null)
    {
        Yii::trace("Started: '$this->id'");

        return $this->runActions(['before', 'make', 'after']);
    }

    public function actionLoad()
    {
        $data = $this->getFile()->load() ?: [];
        if ($data) { /// TODO think what's better
        //  $this->setItems(ArrayHelper::merge($data, $this->toArray()));
            $this->setItems(ArrayHelper::merge($this->toArray(), $data));
        //  $this->setItems($data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function actionSave()
    {
        if ($this->once && $this->exists()) {
            return 0;
        }
        $this->_items = Helper::uniqueConfig($this->_items);
        $this->getFile()->save($this);
    }

    /**
     * Modify action.
     */
    public function actionModify()
    {
        foreach (['chown', 'chgrp', 'chmod'] as $k) {
            $v = $this->{$k};
            if ($v) {
                $this->file->{$k}($v);
            }
        }
    }
}

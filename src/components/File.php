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

use hidev\base\File as FileObj;
use hidev\helpers\Helper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * File component.
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class File extends \hidev\base\Component implements \yii\base\Arrayable, \ArrayAccess, \IteratorAggregate
{
    use \hiqdev\yii2\collection\ObjectTrait;

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
     * @var string specifies handler to be used
     */
    public $fileType;

    /**
     * @var array|FileObj the file to be handled
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

    public function init()
    {
        $this->load();
    }

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
     * @return FileObj
     */
    public function getFile()
    {
        if (!is_object($this->_file)) {
            $this->_file = Yii::createObject(array_merge([
                'class'    => FileObj::class,
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
     * @param mixed $info could be anything that is good for FileObj::create
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

    public function load()
    {
        $data = $this->getFile()->load() ?: [];
        if ($data) { /// TODO think what's better
        //  $this->setItems(ArrayHelper::merge($data, $this->toArray()));
            $this->setItems(ArrayHelper::merge($this->toArray(), $data));
        //  $this->setItems($data);
        }
    }

    /**
     * General save: save and modify.
     */
    public function save()
    {
        if (!$this->once || !$this->exists()) {
            $this->saveFile();
        }
        $this->modifyFile();
    }

    /**
     * Save the file.
     */
    protected function saveFile()
    {
        $this->_items = Helper::uniqueConfig($this->_items);
        $this->getFile()->save($this);
    }

    /**
     * Applies modifications: chown, chgrp, chmod.
     */
    public function modifyFile()
    {
        foreach (['chown', 'chgrp', 'chmod'] as $key) {
            $value = $this->{$key};
            if ($value) {
                $this->file->{$key}($value);
            }
        }
    }
}

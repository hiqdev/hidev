<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\base;

use Yii;
use yii\base\Arrayable;
use yii\base\InvalidParamException;
use hidev\helpers\Helper;

/**
 * A file to be processed with hidev.
 */
class File extends \yii\base\Object
{
    /**
     * @var Goal
     */
    public $goal;

    /**
     * @var file hanler: renderer and parser
     */
    protected $_handler;

    /**
     * @var string absolute path
     */
    protected $_path;

    /**
     * @var string directory
     */
    protected $_dirname;

    /**
     * @var string name with extension
     */
    protected $_basename;

    /**
     * @var string name only, without extension
     */
    protected $_filename;

    /**
     * @var string extension
     */
    protected $_extension;

    /**
     * @var array possible types
     */
    public $types = [];

    /**
     * @var string type
     */
    public $type;

    /**
     * @var string template
     */
    public $template;

    /**
     * @var mixed data
     */
    protected $data;

    /**
     * @var array type to extension correspondance
     */
    protected static $_extension2type = [
        'json'      => 'json',
        'yml'       => 'yaml',  /// first one is preferred
        'yaml'      => 'yaml',
    ];

    public function getExtensionByType($type)
    {
        static $type2extension;
        if ($type2extension === null) {
            foreach (static::$_extension2type as $e => $t) {
                if (!$type2extension[$t]) {
                    $type2extension[$t] = $e;
                }
            }
        }
        return $type2extension[$type];
    }

    public function getTypeByExtension($extension)
    {
        return static::$_extension2type[$extension];
    }

    public function findType()
    {
        return ($this->goal ? $this->goal->fileType : null) ?: static::getTypeByExtension($this->_extension) ?: 'template';
    }

    public function setPath($path)
    {
        $path = Yii::getAlias($path);
        $info = pathinfo($path);
        $this->_path        = $path;
        $this->_dirname     = $info['dirname'];
        $this->_basename    = $info['basename'];
        $this->_filename    = $info['filename'];
        $this->_extension   = $info['extension'];
        $this->type         = $this->findType();
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function setBasename($basename)
    {
        $this->setPath($this->_dirname . '/' . $basename);
    }

    public function getBasename()
    {
        return $this->_basename;
    }

    public function setDirname($dirname)
    {
        $this->setPath($dirname . '/' . $this->_basename);
    }

    public function getDirname()
    {
        return $this->_dirname;
    }

    public function setFilename($filename)
    {
        $this->setPath($this->_dirname . '/' . $filename . '.' . $this->_extension);
    }

    public function getFilename()
    {
        return $this->_filename;
    }

    public function setExtension($extension)
    {
        $this->setPath($this->_dirname . '/' . $this->_filename . '.' . $extension);
    }

    public function getExtension()
    {
        return $this->_extension;
    }

    public function getCtype()
    {
        return Helper::id2camel($this->type);
    }

    public function save($data = null)
    {
        if ($data !== null) {
            $this->data = $data;
        }

        return $this->handler->renderPath($this->path,$this->data);
    }

    public function load()
    {
        return $this->data = $this->handler->parsePath($this->path);
    }

    public function read()
    {
        return $this->handler->read($this->path);
    }

    public function readArray()
    {
        return $this->handler->readArray($this->path);
    }

    public function getHandler()
    {
        if (!is_object($this->_handler)) {
            $this->_handler = Yii::createObject([
                'class'     => 'hidev\handlers\\' . $this->getCtype() . 'Handler',
                'template'  => $this->template,
                'goal'      => $this->goal,
            ]);
        }

        return $this->_handler;
    }

    static public function exists($path)
    {
        return file_exists(Yii::getAlias($path));
    }

    public function find(array $types = [])
    {
        if (!$types) {
            $types = $this->types;
        }
        foreach ($types as $type) {
            foreach (static::$_extension2type as $e => $t) {
                if ($t === $type) {
                    $this->setExtension($e);
                    if (static::exists($this->path)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}

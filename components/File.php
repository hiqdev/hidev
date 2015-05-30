<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\components;

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
     * @var string type
     */
    protected $_type;

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

    public function setPath($path)
    {
        if ('@' === $path[0]) {
        }
            $path = Yii::getAlias($path);
        $info = pathinfo($path);
        $this->_path        = $path;
        $this->_dirname     = $info['dirname'];
        $this->_basename    = $info['basename'];
        $this->_filename    = $info['filename'];
        $this->_extension   = $info['extension'];
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

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function getType()
    {
        if (!$this->_type) {
            $this->_type = static::getTypeByExtension($this->extension) ?: 'template';
        }

        return $this->_type;
    }

    public function getCtype()
    {
        return Helper::id2camel($this->getType());
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

    public function getHandler()
    {
        if (!is_object($this->_handler)) {
            $this->_handler = Yii::createObject([
                'class' => 'hidev\handlers\\' . $this->getCtype(),
                'template' => $this->template,
            ]);
        }

        return $this->_handler;
    }

    static public function exists($path)
    {
        return file_exists(Yii::getAlias($path));
    }
}

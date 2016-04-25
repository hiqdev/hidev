<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use hidev\helpers\Helper;
use Yii;

/**
 * A file to be processed with hidev.
 *
 * @property string $minimalPath path to minimal example file
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
     * @var array file stat
     */
    protected $_stat;

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
     * @var string path to minimal example file
     */
    public $minimal;

    /**
     * Create file object.
     * @param string|array $path or config
     * @return File
     */
    public static function create($path)
    {
        $config = is_array($path) ? $path : compact('path');
        $config['class'] = get_called_class();

        return Yii::createObject($config);
    }

    public function getMinimalPath()
    {
        return Yii::getAlias($this->minimal);
    }

    /**
     * @var array type to extension correspondance
     */
    protected static $_extension2type = [
        'json'      => 'json',
        'yml'       => 'yaml',  /// first one is preferred
        'yaml'      => 'yaml',
        'xml'       => 'xml',
        'xml.dist'  => 'xml',
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
        $path             = Yii::getAlias($path);
        $info             = pathinfo($path);
        $this->_path      = $path;
        $this->_dirname   = $info['dirname'];
        $this->_basename  = $info['basename'];
        $this->_filename  = $info['filename'];
        $this->_extension = $info['extension'];
        $this->type       = $this->findType();
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

    /**
     * Save file.
     * @param mixed $data
     * @return bool true if file was changed
     */
    public function save($data = null)
    {
        if ($data !== null) {
            $this->data = $data;
        }

        return $this->getHandler()->renderPath($this->getPath(), $this->data);
    }

    public function write($content)
    {
        return $this->getHandler()->write($this->getPath(), $content);
    }

    public function load()
    {
        return $this->data = $this->getHandler()->parsePath($this->getPath(), $this->getMinimalPath());
    }

    public function read()
    {
        return $this->getHandler()->read($this->getPath());
    }

    public function readArray()
    {
        return $this->getHandler()->readArray($this->getPath());
    }

    public function getHandler()
    {
        if (!is_object($this->_handler)) {
            $this->_handler = Yii::createObject([
                'class'    => 'hidev\handlers\\' . $this->getCtype() . 'Handler',
                'template' => $this->template,
                'goal'     => $this->goal,
            ]);
        }

        return $this->_handler;
    }

    public static function file_exists($path)
    {
        return file_exists(Yii::getAlias($path));
    }

    public function exists()
    {
        return file_exists($this->getPath());
    }

    public function find(array $types = [])
    {
        if (empty($types)) {
            $types = $this->types;
        }
        foreach ($types as $type) {
            foreach (static::$_extension2type as $e => $t) {
                if ($t === $type) {
                    $this->setExtension($e);
                    if ($this->exists()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function get($name)
    {
        return $this->data[$name];
    }

    public function getStat($field = null)
    {
        if ($this->_stat === null) {
            $this->_stat = stat($this->getPath());
        }

        return is_null($field) ? $this->_stat : $this->_stat[$field];
    }

    public function getUid()
    {
        return (string) $this->getStat(4);
    }

    public function getOwner()
    {
        if (!isset($this->_stat['owner'])) {
            $this->_stat['owner'] = posix_getpwuid($this->getUid());
        }

        return $this->getStat('owner')['name'];
    }

    public function getGid()
    {
        return (string) $this->getStat(5);
    }

    public function getGroup()
    {
        if (!isset($this->_stat['group'])) {
            $this->_stat['group'] = posix_getgrgid($this->getGid());
        }

        return $this->getStat('group')['name'];
    }

    public function getPermissions()
    {
        return static::formatOctal($this->getStat(2));
    }

    public static function formatOctal($value)
    {
        return substr(sprintf('%o', $value), -4);
    }

    public function chmod($value)
    {
        $value = is_int($value) ? static::formatOctal($value) : (string) $value;
        if ($value === $this->getPermissions()) {
            return;
        }
        $path = $this->getPath();
        passthru("chmod $value $path");
        Yii::warning("chmod $path '$value'", 'file');
    }

    public function chown($value)
    {
        $ownergroup = $this->getOwner() . ':' . $this->getGroup();
        if (in_array((string) $value, [$ownergroup, $this->getOwner(), $this->getUid()], true)) {
            return;
        }
        $path = $this->getPath();
        passthru("chown $value $path");
        Yii::warning("chown $path '$value'", 'file');
    }

    public function chgrp($value)
    {
        if (in_array((string) $value, [$this->getGroup(), $this->getGid()], true)) {
            return;
        }
        $path = $this->getPath();
        passthru("chgrp $value $path");
        Yii::warning("chgrp $path '$value'", 'file');
    }
}

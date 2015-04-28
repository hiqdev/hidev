<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev 
 */

namespace hiqdev\hidev\components;

use Yii;
use yii\base\Arrayable;
use yii\base\InvalidParamException;

/**
 * A file to be processed with hidev.
 */
class File extends \yii\base\Object
{

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
    protected $template;

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
        $info = pathinfo($path);
        $this->setDirname($info['dirname']);
        $this->setBasename($info['basename']);
        $this->setFilename($info['filename']);
        $this->setExtension($info['extension']);
    }

    public function getPath()
    {
        if ($this->_path === null) {
            $this->_path = $this->dirname . '/' . $this->basename;
        }

        return $this->_path;
    }

    public function setBasename($basename)
    {
        $this->_basename = $basename;
    }

    public function getBasename()
    {
        if ($this->_basename === null) {
            $this->_basename = $this->filename . '.' . $this->extension;
        }

        return $this->_basename;
    }

    public function setDirname($dirname)
    {
        $this->_dirname = $dirname;
    }

    public function getDirname()
    {
        return $this->_dirname;
    }

    public function setFilename($filename)
    {
        $this->_filename = $filename;
    }

    public function getFilename()
    {
        return $this->_filename;
    }

    public function setExtension($extension)
    {
        $this->_extension = $extension;
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
            $this->_type = static::getTypeByExtension($this->extension);
        }
        return $this->_type;
    }

    public static function create($config)
    {
        if (is_string($config)) {
            $config = ['path' => $config];
        } elseif (!is_array($config)) {
            throw new InvalidParamException("Can't create file from: " . gettype($config));
        }

        return Yii::createObject(array_merge([
            'class' => static::className(),
        ], $config));
    }

    public function save($data = null)
    {
        if ($data !== null) {
            $this->data = $data;
        }
        
        $this->write($this->render());
    }

    /**
     * Writes given conten to the file.
     * TODO Creates intermediate directories when necessary.
     */
    protected function write($content)
    {
        Yii::info('Written file: '.$this->path,'file');
        file_put_contents($this->path,$this->render());
    }

    public function render($data = null)
    {
        $renderer = Yii::createObject([
            'class' => 'hiqdev\hidev\components\\' . ucfirst($this->type) . 'Renderer',
            'template' => $this->template,
        ]);

        return $renderer->render(is_null($data) ? $this->data : $data);
    }

    public function exists()
    {
        return file_exists($this->path);
    }
}

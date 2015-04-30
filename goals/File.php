<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev 
 */

namespace hiqdev\hidev\goals;

use Yii;
use hiqdev\hidev\components\File as zFile;
use hiqdev\hidev\helpers\Inflector;

/**
 * A File Goal.
 */
class File extends Base
{

    /**
     * @var array|File the file to be handled.
     */
    protected $_file;

    protected $_template;

    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    public function getTemplate()
    {
        return Inflector::file2template($this->_template ?: $this->_file);
    }

    /**
     * Returns file object.
     * Instantiates it with zFile::create if necessary.
     *
     * @return zFile
     */
    public function getFile()
    {
        if (!is_object($this->_file)) {
            $this->_file = Yii::createObject([
                'class'     => zFile::className(),
                'path'      => $this->_file,
                'template'  => $this->getTemplate(),
            ]);
        }

        return $this->_file;
    }

    /**
     * Sets file with given info.
     *
     * @param mixed $info could be anything that is good for zFile::create
     */
    public function setFile($info)
    {
        $this->_file = $info;
    }

    public function getDirname()
    {
        return $this->file->getDirname();
    }

    public function getPath()
    {
        return $this->file->getPath();
    }

    public function save($data = null)
    {
        return $this->file->save($data);
    }
}

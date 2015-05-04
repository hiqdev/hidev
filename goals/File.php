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
use hiqdev\hidev\components\File as FileComponent;
use hiqdev\hidev\helpers\Helper;

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
        return Helper::file2template($this->_template ?: $this->name);
    }

    /**
     * Returns file object.
     * Instantiates it if necessary.
     *
     * @return FileComponent
     */
    public function getFile()
    {
        if (!is_object($this->_file)) {
            $this->_file = Yii::createObject([
                'class'     => FileComponent::className(),
                'path'      => $this->_file ?: $this->name,
                'template'  => $this->getTemplate(),
            ]);
        }

        return $this->_file;
    }

    /**
     * Sets file with given info.
     *
     * @param mixed $info could be anything that is good for FileComponent::create
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

    public function load()
    {
        return $this->file->load();
    }

    public function save()
    {
        return $this->file->save($this);
    }

    public function make()
    {
        /// XXX $this->load();
        $this->save();
    }
}

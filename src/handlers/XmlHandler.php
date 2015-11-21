<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use hiqdev\php\collection\ArrayHelper;

/**
 * Handler for XML files.
 */
class XmlHandler extends TypeHandler
{
    protected $_xml;

    /**
     * {@inheritdoc}
     */
    public function renderType($data)
    {
        d($data);
    }

    /**
     * {@inheritdoc}
     */
    public function parsePath($path)
    {
        $this->_xml = simplexml_load_file($path);
        return ArrayHelper::toArray($this->_xml);
    }
}

<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
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
        return $this->_xml->asXML();
    }

    /**
     * {@inheritdoc}
     */
    public function parsePath($path, $minimal = null)
    {
        $this->_xml = simplexml_load_file(file_exists($path) ? $path : $minimal);

        return ArrayHelper::toArray($this->_xml);
    }
}

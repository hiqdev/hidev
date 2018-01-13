<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

/**
 * Handler for plain file operations.
 */
class PlainHandler extends BaseHandler
{
    /**
     * {@inheritdoc}
     */
    public function render($data)
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($input)
    {
        return $input;
    }
}

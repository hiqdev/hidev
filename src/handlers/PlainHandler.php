<?php

/*
 * Build tool mixed with code generator for easier automation and continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
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

<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use Yii;

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

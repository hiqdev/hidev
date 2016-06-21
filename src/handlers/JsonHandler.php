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

use yii\helpers\Json;

/**
 * Handler for JSON files.
 */
class JsonHandler extends TypeHandler
{
    /**
     * {@inheritdoc}
     */
    public function renderType($data)
    {
        return Json::encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
    }

    /**
     * {@inheritdoc}
     */
    public function parse($json)
    {
        return $json ? Json::decode($json) : [];
    }
}

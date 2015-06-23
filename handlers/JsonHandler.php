<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\handlers;

use yii\helpers\Json;

/**
 * Handler for JSON files.
 */
class JsonHandler extends TypeHandler
{
    /**
     * @inheritdoc
     */
    public function renderType($data)
    {
        return Json::encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
    }

    /**
     * @inheritdoc
     */
    public function parse($json)
    {
        return Json::decode($json);
    }
}
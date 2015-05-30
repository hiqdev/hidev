<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\handlers;

use Yii;
use yii\helpers\Json AS JsonHelper;

/**
 * Handler for JSON files.
 */
class Json extends Type
{

    /**
     * @inheritdoc
     */
    public function renderType($data)
    {
        return JsonHelper::encode($data,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)."\n";
    }

    public function parse($json)
    {
        return JsonHelper::decode($json);
    }
}

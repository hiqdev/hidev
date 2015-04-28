<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev 
 */

namespace hiqdev\hidev\components;

use Yii;
use yii\helpers\Json;

/**
 * Renderer to JSON.
 */
class JsonRenderer extends BaseRenderer
{

    /**
     * @inheritdoc
     */
    public function render($data)
    {
        return Json::encode($data,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)."\n";
    }

}

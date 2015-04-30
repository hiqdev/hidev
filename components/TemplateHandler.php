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

/**
 * Handler for templated files.
 */
class TemplateHandler extends BaseHandler
{

    /**
     * @inheritdoc
     */
    public function renderPrepared($data)
    {
        return $this->getView()->render($this->template, $data, Yii::$app->config);
    }

    public function prepareData($data)
    {
        return array_merge([
            'config'    => Yii::$app->config,
        ],$data ?: []);
    }

    public function parse($json)
    {
        die("can't parse template");
    }
}

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

/**
 * Handler for templated files.
 */
class Template extends Base
{

    /**
     * @inheritdoc
     */
    public function renderPrepared($data)
    {
        return $this->getView()->render($this->template, $data);
    }

    public function renderTemplate($data)
    {
        return $this->renderPrepared(self::prepareData($data));
    }

    public function prepareData($data)
    {
        return array_merge([
            'config' => Yii::$app->config,
        ], parent::prepareData($data));
    }

    public function parse($json)
    {
        return [];
    }

    public function existsTemplate()
    {
        return $this->view->existsTemplate($this->template);
    }
}

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
            'this'   => $this,
            'file'   => $data->file,
        ], parent::prepareData($data));
    }

    public function parse($json)
    {
        return [];
    }

    public function existsTemplate()
    {
        return $this->template && $this->view->existsTemplate($this->template);
    }
}

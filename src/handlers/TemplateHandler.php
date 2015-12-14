<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use Yii;

/**
 * Handler for templated files.
 */
class TemplateHandler extends BaseHandler
{
    /**
     * {@inheritdoc}
     */
    public function renderPrepared(array $data)
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

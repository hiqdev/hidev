<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use yii\helpers\Yii;

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
            'app'     => Yii::$app,
            'config'  => Yii::$app, /// DEPRECATED
            'file'    => $data->file,
            'handler' => $this,
        ], parent::prepareData($data));
    }

    public function existsTemplate()
    {
        return $this->template && $this->getView()->existsTemplate($this->template);
    }
}

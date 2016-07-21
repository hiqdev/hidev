<?php

/*
 * Automation tool mixed with code generator for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use Yii;

/**
 * Our View.
 */
class View extends \yii\base\View
{
    /**
     * {@inheritdoc}
     */
    public $defaultExtension = 'twig';

    public function init()
    {
        parent::init();
        $this->theme->pathMap['@app/views'] = array_merge(
            (array) $this->theme->pathMap['@app/views'],
            (array) Yii::$app->get('config')->rawItem('views')
        );
    }

    public function getConfig()
    {
        return Yii::$app->config;
    }

    /**
     * Returns rendering context.
     */
    public function getContext()
    {
        return Yii::$app;
    }

    public function existsTemplate($template)
    {
        return file_exists($this->findViewFile($template, $this->getContext()));
    }

    public function render($template, $data = [], $context = null)
    {
        return parent::render($template, $data, isset($context) ? $context : $this->getContext());
    }
}

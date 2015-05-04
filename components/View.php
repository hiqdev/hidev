<?php

namespace hiqdev\hidev\components;

use Yii;

/**
 * Our View.
 * Redefined for extending.
 */
class View extends \yii\web\View
{

    public function getConfig()
    {
        return Yii::$app->config;
    }

    /**
     * Returns rendering context.
     *
     * TODO think of moving to other object from Config Goal
     */
    public function getContext()
    {
        return Yii::$app;
    }

    public function existsTemplate($template)
    {
        return file_exists($this->findViewFile($template, $this->getContext()));
    }

    public function render($template, $data)
    {
        return parent::render($template, $data, $this->getContext());
    }
}

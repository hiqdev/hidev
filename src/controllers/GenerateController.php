<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Generate goal to build files by template and params.
 */
class GenerateController extends TemplateController
{
    public static function template2file($template, $extension = '.php')
    {
        $a = pathinfo($template);

        return $a['dirname'] . '/' . $a['filename'] . $extension;
    }

    public function actionPerform($template = null, $file = null)
    {
        $this->template = $template;
        $this->file     = $file ?: static::template2file($template);

        return parent::actionPerform();
    }

    public function actionOnce($template, $file = null)
    {
        $file = $file ?: static::template2file($template);
        if (file_exists($file)) {
            return;
        }

        return $this->actionPerform($template, $file);
    }
}

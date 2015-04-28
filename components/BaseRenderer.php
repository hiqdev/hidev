<?php

/*
 * HiDev.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\components;

use yii\helpers\ArrayHelper;

/**
 * Base Renderer.
 */
class BaseRenderer extends \yii\base\Object
{
    /**
     * @var string template file name to be used for rendering
     */
    public $template;

    /**
     * Outputs file content using given data.
     *
     * @param array $data
     *
     * @return string file content
     */
    public function output(array $data)
    {
        return '';
    }

    /**
     * Renders file content using given data.
     * Converts to array with ArrayHelper::toArray.
     *
     * @param mixed $data
     *
     * @return string file content
     */
    public function render($data)
    {
        return $this->output(ArrayHelper::toArray($data));
    }

}

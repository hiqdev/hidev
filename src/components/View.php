<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use yii\base\ViewContextInterface;

/**
 * Our View.
 */
class View extends \yii\base\View implements ViewContextInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultExtension = 'twig';

    protected $_viewPath;

    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = '@hidev/views';
        }

        return $this->_viewPath;
    }

    /**
     * Returns rendering context.
     */
    public function getContext($context = null)
    {
        return $context ?: $this;
    }

    public function existsTemplate($template, $context = null)
    {
        return file_exists($this->findViewFile($template, $this->getContext($context)));
    }

    public function render($template, $data = [], $context = null)
    {
        return parent::render($template, $data, $this->getContext($context));
    }
}

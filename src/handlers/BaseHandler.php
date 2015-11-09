<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Base Handler.
 * Knows how to parse and render it's file type.
 */
class BaseHandler extends \yii\base\Object
{
    /**
     * @var Goal
     */
    public $goal;

    /**
     * @var string template file name to be used for rendering
     */
    public $template;

    /**
     * @var View object.
     */
    protected $_view;

    /**
     * Returns the view object that can be used to render views or view files.
     * If not set, it will default to the "view" application component.
     *
     * @return View|\yii\web\View the view object that can be used to render views or view files.
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }

        return $this->_view;
    }

    /**
     * Renders prepared data.
     * Must be redefined in child.
     *
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return string file content
     */
    public function renderPrepared(array $data)
    {
        throw new InvalidConfigException('Render not available');
    }

    /**
     * Renders raw data.
     * Prepares data with ArrayHelper::toArray.
     *
     * @param mixed $data
     *
     * @return string file content
     */
    public function render($data)
    {
        return $this->renderPrepared($this->prepareData($data));
    }

    public function prepareData($data)
    {
        return ArrayHelper::toArray($data);
    }

    /**
     * Renders file content using given data.
     * Converts to array with ArrayHelper::toArray.
     *
     * @param mixed $data
     *
     * @return string file content
     */
    public function renderPath($path, $data)
    {
        return $this->write($path, $this->render($data));
    }

    public function parsePath($path)
    {
        return $this->parse($this->read($path));
    }

    /**
     * Writes given content to the file.
     * TODO Creates intermediate directories when necessary.
     */
    protected function write($path, $content)
    {
        if (!is_file($path) || file_get_contents($path) !== $content) {
            Yii::warning('Written file: ' . $path, 'file');
            file_put_contents($path, $content);
        }
    }

    public function read($path, $asArray = false)
    {
        if (file_exists($path)) {
            Yii::info('Read file: ' . $path, 'file');

            return $asArray ? file($path) : file_get_contents($path);
        } else {
            Yii::error('Couldn\'t read file: ' . $path, 'file');

            return;
        }
    }

    public function readArray($path)
    {
        return $this->read($path, true);
    }
}

<?php

/*
 * HiDev.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\handlers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Base Handler.
 * Knows how to parse and render it's file type.
 */
class Base extends \yii\base\Object
{
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
     * @return string file content
     */
    public function renderPrepared(array $data)
    {
        throw new InvalidParamException("Render not available");
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
        return $this->write($path,$this->render($data));
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
        $old = $this->read($path);
        if ($old != $content) {
            Yii::warning('Written file: ' . $path, 'file');
            file_put_contents($path, $content);
        }
    }

    public function read($path)
    {
        if (file_exists($path)) {
            Yii::info('Read file: ' . $path, 'file');
            return file_get_contents($path);
        } else {
            Yii::error('Couldn\'t read file: ' . $path, 'file');
            return null;
        }
    }

}

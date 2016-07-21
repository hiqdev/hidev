<?php

/*
 * Automation tool mixed with code generator for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
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
        return ArrayHelper::toArray($data, [], false);
        #return $data;
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

    public function parsePath($path, $minimal = null)
    {
        return $this->parse($this->read($path));
    }

    /**
     * Parses string input. To be redefined in real handlers.
     * @param string $input to parse
     * @return array
     */
    public function parse($input)
    {
        return [];
    }

    /**
     * Writes given content to the file.
     * Doesn't touch file if it has exactly same content.
     * Creates intermediate directories when necessary.
     * @param string $path
     * @param string $content
     * @return bool true if file was changed
     */
    public function write($path, $content)
    {
        if (!is_file($path) || file_get_contents($path) !== $content) {
            $this->mkdir(dirname($path));
            file_put_contents($path, $content);
            Yii::warning('Written file: ' . $path, 'file');

            return true;
        }

        return false;
    }

    /**
     * Creates directory if not exists.
     * @param string $path
     * @return bool true if directory did not exist and was created
     */
    public function mkdir($path)
    {
        $path = rtrim(trim($path), '/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            Yii::warning('Created dir:  ' . $path . '/', 'file');

            return true;
        }

        return false;
    }

    /**
     * Read file into a string or array.
     * @param string $path
     * @param bool $asArray
     * @return string|array
     */
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

    /**
     * Read file into array of strings.
     * @param string $path
     * @return array
     */
    public function readArray($path)
    {
        return $this->read($path, true);
    }
}

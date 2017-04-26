<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use hidev\helpers\ConfigPlugin;
use hidev\controllers\AliasController;
use Yii;
use yii\base\ViewContextInterface;
use yii\helpers\ArrayHelper;

/**
 * The Application.
 */
class Application extends \yii\console\Application implements ViewContextInterface
{
    protected $_viewPath;

    protected $_config;

    protected $_first = true;

    public function __construct($config = [])
    {
        $this->_config = $config;
        parent::__construct($config);
    }

    protected $controllers = [];

    public function createControllerByID($id)
    {
        if (isset($this->controllers[$id])) {
            return $this->controllers[$id];
        }

        $controller = parent::createControllerByID($id);
        if ($controller instanceof AliasController) {
            $controller = $controller->getController();
        }
        $this->controllers[$id] = $controller;

        return $controller;
    }

    /**
     * Run request.
     * @param string|array $query
     * @return Response
     */
    public function runRequest($query)
    {
        $request = Yii::createObject([
            'class'  => 'hidev\base\Request',
            'params' => is_array($query) ? $query : array_filter(explode(' ', $query)),
        ]);

        return $this->handleRequest($request);
    }
}

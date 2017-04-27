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

    protected $controllers = [];

    public function createController($route)
    {
        $res = parent::createController($route);
        if (!is_array($res)) {
            return $res;
        }
            list($controller, $subroute);
        }

        // module and controller map take precedence
        if (isset($this->controllerMap[$id])) {
            $definition = $this->controllerMap[$id];
            $controller = is_object($definition) ? $definition : Yii::createObject($definition, [$id, $this]);
            return [$controller, $route];
        }
        $module = $this->getModule($id);
        if ($module !== null) {
            return $module->createController($route);
        }

        if (($pos = strrpos($route, '/')) !== false) {
            $id .= '/' . substr($route, 0, $pos);
            $route = substr($route, $pos + 1);
        }

        $controller = $this->createControllerByID($id);
        if ($controller === null && $route !== '') {
            $controller = $this->createControllerByID($id . '/' . $route);
            $route = '';
        }

        return $controller === null ? false : [$controller, $route];
    }

    private function parseRoute($route)
    {
        if ($route === '') {
            $route = $this->defaultRoute;
        }

        // double slashes or leading/ending slashes may cause substr problem
        $route = trim($route, '/');
        if (strpos($route, '//') !== false) {
            return false;
        }

        if (strpos($route, '/') !== false) {
            list ($id, $route) = explode('/', $route, 2);
        } else {
            $id = $route;
            $route = '';
        }

        return [$id, $route];
    }

    private function extractId($route)
    {
        return $this->parseRoute($route)[0];
    }

    private function saveController($id, $controller)
    {
        $this->controllers[$id] = $controller;
    }

    private function returnProxy($result)
    {

    }

    public function createControllerByID($id)
    {
        if (isset($this->controllers[$id])) {
            return $this->controllers[$id];
        }

        $controller = parent::createControllerByID($id);
        if ($id === 'readme') {
            var_dump($controller);
            die;
        };
        if ($controller instanceof AliasController) {
            $controller = $controller->getController();
        }
        $this->controllers[$id] = $controller;

        return $controller;
    }
}

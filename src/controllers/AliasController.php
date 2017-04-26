<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Alias controller.
 */
class AliasController extends AbstractController
{
    public $alias;

    public function getController()
    {
        return $this->module->createController($this->alias);
    }
}

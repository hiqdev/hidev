<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

/**
 * Handler for typed files.
 *
 * If there is a template then renders with it.
 * Else renders with renderType.
 */
class TypeHandler extends TemplateHandler
{
    public function render($data)
    {
        return $this->existsTemplate() ? $this->renderTemplate($data) : $this->renderType($data);
    }
}

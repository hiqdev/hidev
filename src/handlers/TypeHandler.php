<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
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

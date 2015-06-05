<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\handlers;

use Yii;

/**
 * Handler for typed files.
 *
 * If there is a template then renders with it.
 * Else renders with renderType.
 */
class Type extends Template
{

    public function render($data)
    {
        return $this->existsTemplate() ? $this->renderTemplate($data) : $this->renderType($data);
    }
}

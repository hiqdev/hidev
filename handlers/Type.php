<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\handlers;

use Yii;
use yii\helpers\Json;

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

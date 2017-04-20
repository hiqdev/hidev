<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\modifiers;

interface ModifierInterface
{
    /**
     * Modifies.
     * @param mixed $value
     * @return mixed
     */
    public function modify($value);
}

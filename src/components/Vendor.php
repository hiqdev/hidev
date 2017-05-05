<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use hidev\helpers\Helper;

/**
 * Vendor part of the config.
 */
class Vendor extends \hidev\base\Component
{
    use \hiqdev\yii2\collection\ObjectTrait;

    public function getLabel()
    {
        return $this->getItem('label') ?: ucfirst($this->name);
    }

    public function getTitle()
    {
        return $this->getItem('title') ?: $this->getItem('description') ?: Helper::titleize($this->name);
    }

    public function getTitleAndHomepage()
    {
        return $this->title . ($this->homepage ? ' (' . $this->homepage . ')' : '');
    }

    public function getDescription()
    {
        return $this->getItem('description') ?: $this->getTitle();
    }
}

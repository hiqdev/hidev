<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;

/**
 * Vendor part of the config.
 */
class VendorGoal extends DefaultGoal
{
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

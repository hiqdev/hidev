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

use Yii;

/**
 * Vendor part of the config.
 */
class VendorGoal extends DefaultGoal
{
    public function getTitleAndHomepage()
    {
        return $this->title . ($this->homepage ? ' (' . $this->homepage . ')' : '');
    }

    protected $_authors;

    public function getAuthors()
    {
        if (!is_object($this->_authors)) {
            $this->_authors = new AuthorGoal(['items' => $this->_authors]);
            /// XXX strangely later doesn't work :-/ investigate later
            /// $this->_data = Author::createItem('', $this->_data);
        }

        return $this->_authors;
    }

    public function setAuthors($authors)
    {
        $this->_authors = $authors;
    }

    public function getConfig()
    {
        return Yii::$app->config;
    }
}

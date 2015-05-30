<?php

/*
 * HiDev
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\goals;

use Yii;

/**
 * Vendor part of the config.
 */
class Vendor extends \hiqdev\collection\Model
{
    public function rules()
    {
        return [
            ['type',            'safe'],
            ['name',            'safe'],
            ['title',           'safe'],
            ['homepage',        'safe'],
            ['description',     'safe'],
        ];
    }

    public function getTitleAndHomepage()
    {
        return $this->title . ($this->homepage ? ' (' . $this->homepage . ')' : '');
    }

    protected $_authors;

    public function getAuthors()
    {
        if (!is_object($this->_authors)) {
            $this->_authors = new Author(['items' => $this->_authors]);
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

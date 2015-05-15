<?php

/*
 * HiDev
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;
use hiqdev\hidev\helpers\Helper;

/**
 * Package part of the config.
 */
class Package extends Vendor
{
    public function rules()
    {
        return [
            ['type',            'safe'],
            ['name',            'safe'],
            ['label',           'safe'],
            ['title',           'safe'],
            ['description',     'safe'],
            ['license',         'safe'],
            ['keywords',        'safe'],
            ['namespace',       'safe'],
        ];
    }

    public function getLabel()
    {
        return $this->getItem('label') ?: ucfirst($this->name);
    }

    public function getYears()
    {
        $cur = (integer)date('Y');
        $old = (integer)$this->year;
        return ($old && $old<$cur ? $this->year . '-' : '') . $cur;
    }

    public function getIssues()
    {
        return $this->getItem('issues') ?: ($this->source . '/issues');
    }

    public function getWiki()
    {
        return $this->getItem('wiki') ?: ($this->source . '/wiki');
    }

    public function getKeywords()
    {
        return Helper::csplit($this->getItem('keywords'));
    }

    public function getFullName()
    {
        return $this->getItem('fullName') ?: ($this->getVendor()->name . '/' . $this->name);
    }

    public function getSource()
    {
        return $this->getItem('source') ?: ('https://github.com/' . $this->fullName);
    }

    public function getNamespace()
    {
        return $this->getItem('namespace') ?: ($this->getVendor()->name . '\\' . $this->name);
    }

    public function getAuthors()
    {
        return $this->_authors ? parent::getAuthors() : $this->vendor->authors;
    }

    public function getVendor()
    {
        return $this->getConfig()->vendor;
    }

}

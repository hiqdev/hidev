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

    public function setLabel($label)
    {
        $this->setItem('label', $label);
    }

    public function getYears()
    {
        $cur = (integer)date('Y');
        $old = (integer)$this->year;
        return ($old && $old<$cur ? $this->year . '-' : '') . $cur;
    }

    public function setIssues($issues)
    {
        $this->setItem('issues', $issues);
    }

    public function getIssues()
    {
        return $this->getItem('issues') ?: ($this->getItem('source') . '/issues');
    }

    public function setWiki($wiki)
    {
        $this->setItem('wiki', $wiki);
    }

    public function getWiki()
    {
        return $this->getItem('wiki') ?: ($this->getItem('source') . '/wiki');
    }

    public function setKeywords($keywords)
    {
        $this->setItem('keywords', array_map('trim',explode(',',$keywords)));
    }

    public function getKeywords()
    {
        return $this->getItem('keywords');
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

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

use hidev\helpers\Helper;

/**
 * Package part of the config.
 */
class PackageGoal extends VendorGoal
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

    public function getLicense()
    {
        return $this->getItem('license') ?: $this->vendor->license ?: 'No license';
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

    public function getSrc()
    {
        return $this->rawItem('src') ?: '';
    }

    public function getHomepage()
    {
        return $this->getItem('homepage') ?: ($this->vendor->homepage . $this->name);
    }

    public function getDescription()
    {
        return $this->getItem('description') ?: $this->title;
    }

    public function getAuthors()
    {
        return $this->_authors ? parent::getAuthors() : $this->vendor->authors;
    }

    public function getVendor()
    {
        return $this->getConfig()->getVendor();
    }

}

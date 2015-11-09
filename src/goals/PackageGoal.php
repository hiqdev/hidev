<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;

/**
 * Package part of the config.
 */
class PackageGoal extends VendorGoal
{
    public function getYears()
    {
        $cur = (integer) date('Y');
        $old = (integer) $this->year;

        return ($old && $old < $cur ? $this->year . '-' : '') . $cur;
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
        return $this->getItem('namespace') ?: $this->config->composer->namespace ?: self::defaultNamespace($this->getVendor()->name, $this->name);
    }

    public static function defaultNamespace($vendor, $package)
    {
        return $vendor . '\\' . strtr($package, '-', '\\');
    }

    public function getSrc()
    {
        return $this->rawItem('src') ?: 'src';
    }

    public function getHomepage()
    {
        return $this->getItem('homepage') ?: $this->getSource();
    }

    public function getForum()
    {
        return $this->getItem('forum') ?: $this->vendor->forum;
    }

    public function getLabel()
    {
        return $this->getItem('label') ?: ucfirst($this->name);
    }

    public function getTitle()
    {
        return $this->getItem('title') ?: Helper::titleize($this->name);
    }

    public function getHeadline()
    {
        return $this->getItem('headline') ?: $this->getTitle();
    }

    public function getDescription()
    {
        return $this->getItem('description') ?: $this->getTitle();
    }

    public function getRepositoryUrl($file)
    {
        return 'https://github.com/' . $this->getFullName() . '/blob/master/' . $file;
    }
    public function getAuthors()
    {
        return $this->getItem('authors') ?: $this->vendor->authors;
    }

    public function getVendor()
    {
        return $this->getConfig()->getVendor();
    }
}

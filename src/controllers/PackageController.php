<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use hidev\helpers\Helper;

/**
 * Package part of the config.
 */
class PackageController extends CommonController
{
    use \hiqdev\yii2\collection\ObjectTrait;

    public function getYears()
    {
        $cur = (integer) date('Y');
        $old = (integer) $this->year;

        return ($old && $old < $cur ? $this->year . '-' : '') . $cur;
    }

    public function getYear()
    {
        return $this->getItem('year') ?: $this->takeVcs()->getYear();
    }

    public function getLicense()
    {
        return $this->getItem('license') ?: $this->takeVendor()->license ?: 'No license';
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
        return $this->getItem('fullName') ?: ($this->takeVendor()->name . '/' . $this->name);
    }

    public function getSource()
    {
        return $this->getItem('source') ?: ('https://github.com/' . $this->takeGoal('github')->name);
    }

    public function getNamespace()
    {
        return $this->getItem('namespace') ?: $this->getPackageManager()->namespace ?: self::defaultNamespace($this->takeVendor()->name, $this->name);
    }

    public static function defaultNamespace($vendor, $package)
    {
        return preg_replace('/[^a-zA-Z0-9\\\\]+/', '', $vendor . strtr("-$package", '-', '\\'));
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
        return $this->getItem('forum') ?: $this->takeVendor()->forum;
    }

    public function getLabel()
    {
        return $this->getItem('label') ?: $this->getHeadline() ?: Helper::id2camel($this->name);
    }

    public function getTitle()
    {
        return $this->getItem('title') ?: Helper::titleize($this->name);
    }

    public function getHeadline()
    {
        return $this->getItem('headline');
    }

    public function getDescription()
    {
        return $this->getItem('description');
    }

    public function getRepositoryUrl($file)
    {
        return 'https://github.com/' . $this->getFullName() . '/blob/master/' . $file;
    }
    public function getAuthors()
    {
        return $this->getItem('authors') ?: $this->takeVendor()->authors;
    }

    /**
     * Composer for the moment.
     * To be changed to get actual Package Manager.
     */
    public function getPackageManager()
    {
        return $this->takeGoal('composer');
    }

    public function hasRequireAny($package)
    {
        return $this->hasRequire($package) || $this->hasRequireDev($package);
    }

    public function hasRequire($package)
    {
        $conf = $this->getPackageManager()->getConfiguration();
        return array_key_exists($package, $conf->getRequire());
    }

    public function hasRequireDev($package)
    {
        $conf = $this->getPackageManager()->getConfiguration();
        return array_key_exists($package, $conf->getRequireDev());
    }
}

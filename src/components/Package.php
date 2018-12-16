<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use hidev\helpers\Helper;

/**
 * Package part of the config.
 * @property string name
 * @property string year
 * @property string source
 */
class Package extends \hidev\base\Component
{
    public $type = 'project';

    public $name;
    public $title;
    public $headline;
    public $description;

    protected $_keywords = [];
    protected $_fullName;
    protected $_license;
    protected $_years;
    protected $_year;

    public function getLanguage()
    {
        return $this->getItem('language') ?: 'php';
    }

    public function getYears()
    {
        if (!empty($this->_years)) {
            return $this->_years;
        }

        $cur = (int) date('Y');
        $old = (int) $this->year;

        return ($old && $old < $cur ? $this->year . '-' : '') . $cur;
    }

    public function setYear(int $year): self
    {
        $this->_year = $year;

        return $this;
    }

    public function getYear()
    {
        return $this->_year ?: null;
        /// TODO enable it back
        #return $this->_year ?: $this->take('vcs')->getYear();
    }

    public function setLicense(string $license): self
    {
        $this->_license = $license;

        return $this;
    }

    public function getLicense()
    {
        return $this->_license ?: $this->take('vendor')->license ?: 'No license';
    }

    public function getIssues()
    {
        return $this->getItem('issues') ?: ($this->source . '/issues');
    }

    public function getWiki()
    {
        return $this->getItem('wiki') ?: ($this->source . '/wiki');
    }

    public function setKeywords($keywords): self
    {
        if (!is_array($keywords)) {
            $keywords = Helper::csplit((string)$keywords);
        }
        $this->_keywords = $keywords;

        return $this;
    }

    public function getKeywords()
    {
        return $this->_keywords;
    }

    public function getFullName()
    {
        return $this->_fullName ?: ($this->take('vendor')->name . '/' . $this->name);
    }

    public function getSource()
    {
        return $this->getItem('source') ?: ('https://github.com/' . $this->take('github')->full_name);
    }

    public function getVersion()
    {
        return $this->take('version')->version;
    }

    public function getNamespace()
    {
        return $this->getItem('namespace')
            ?: $this->getPackageManager()->getConfiguration()->namespace
            ?: self::defaultNamespace($this->take('vendor')->name, $this->name);
    }

    public static function defaultNamespace($vendor, $package)
    {
        return preg_replace('/[^a-zA-Z0-9\\\\]+/', '', $vendor . strtr("-$package", '-', '\\'));
    }

    public function getSrc()
    {
        $src = $this->rawItem('src');

        return isset($src) ? $src : 'src';
    }

    public function getHomepage()
    {
        return $this->getItem('homepage') ?: ($this->isDomain() ? 'http://' . $this->name . '/' : $this->getSource());
    }

    public function getForum()
    {
        return $this->getItem('forum') ?: $this->take('vendor')->forum;
    }

    public function getLabel()
    {
        return $this->getItem('label') ?: $this->getHeadline() ?: Helper::id2camel($this->name);
    }

    public function isDomain()
    {
        return preg_match('/^[a-z0-9-]+(\.[a-z0-9]+)+$/', $this->name);
    }

    public function getTitle()
    {
        return $this->_title ?: ($this->isDomain() ? $this->name : Helper::titleize($this->name));
    }

    public function getRepositoryUrl($file)
    {
        return 'https://github.com/' . $this->getFullName() . '/blob/master/' . $file;
    }

    public function getAuthors()
    {
        return $this->getItem('authors') ?: $this->take('vendor')->authors;
    }

    /**
     * Composer for the moment.
     * To be changed to get actual Package Manager.
     */
    public function getPackageManager()
    {
        return $this->getApp()->has('composer') ? $this->take('composer') : null;
    }

    public function hasRequireAny($package)
    {
        return $this->hasRequire($package) || $this->hasRequireDev($package);
    }

    public function hasRequire($package)
    {
        $pman = $this->getPackageManager();

        return $pman && array_key_exists($package, $pman->getConfiguration()->getRequire());
    }

    public function hasRequireDev($package)
    {
        $pman = $this->getPackageManager();

        return $pman && array_key_exists($package, $pman->getConfiguration()->getRequireDev());
    }
}

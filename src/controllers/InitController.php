<?php

/*
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Exception;
use hidev\helpers\Helper;
use yii\base\InvalidParamException;

/**
 * Init controller.
 * Builds .hidev/config.yml by template and params.
 */
class InitController extends TemplateController
{
    protected $_file = '.hidev/config.yml';

    public $vendor;
    public $package;

    public function prepareData($name)
    {
        list($vendor, $package) = explode('/', $name, 2);
        if ($vendor) {
            $this->vendor = $vendor;
            $vendorPlugin = "$vendor/hidev-$vendor";
            try {
                $exists = @file_get_contents("https://packagist.org/packages/$vendorPlugin.json");
            } catch (Exception $e) {
                $exists = false;
            }
            if ($exists) {
                $this->setItem('vendorRequire', str_pad($vendorPlugin . ':', 23) . ' "*"');
                $this->setItem('novendor', true);
            }
        }
        if ($package) {
            $this->package = $package;
        }
        if (!$this->package || !$this->vendor) {
            throw new InvalidParamException('Wrong vendor/package given: ' . $name);
        }
    }

    public function actionPerform($name = null, $template = '.hidev/config')
    {
        $this->_template = $template;
        $this->prepareData($name);
        if (!file_exists($this->dirname)) {
            mkdir($this->dirname);
        }

        return parent::actionPerform();
    }

    public function options($actionId)
    {
        return array_merge(parent::options($actionId), explode(',', 'namespace,headline,title,type,license,keywords,description,year,nick,author,email,novendor,norequire'));
    }

    public function getType()
    {
        return $this->getItem('type') ?: 'project';
    }

    public function getTitle()
    {
        return $this->getItem('title') ?: Helper::titleize($this->package);
    }

    public function getKeywords()
    {
        return $this->getItem('keywords') ?: implode(', ', explode('-', $this->package));
    }

    /// TODO think of better getting nick
    public function getNick()
    {
        return $this->getItem('nick') ?: preg_replace('/[^a-zA-Z_0-9]+/', '', `id -un`);
    }

    public function getAuthor()
    {
        return $this->getItem('author') ?: $this->takeVcs()->getUserName();
    }

    public function getEmail()
    {
        return $this->getItem('email') ?: $this->takeVcs()->getUserEmail();
    }
}

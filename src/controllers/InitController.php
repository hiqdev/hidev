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
use yii\base\InvalidParamException;

/**
 * Init controller.
 * Builds .hidev/config.yml by template and params.
 */
class InitController extends TemplateController
{
    use \hiqdev\yii2\collection\ObjectTrait;

    protected $_file = '.hidev/config.yml';

    public $vendor;
    public $package;

    public function actionPerform($name = null, $template = '.hidev/config')
    {
        list($vendor, $package) = explode('/', $name, 2);
        if ($vendor) {
            $this->vendor = $vendor;
        }
        if ($package) {
            $this->package = $package;
        }
        if (!$this->package || !$this->vendor) {
            throw new InvalidParamException('Wrong vendor/package given: ' . $name);
        }
        $this->template = $template;

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
        return $this->getItem('author') ?: $this->getVcs()->getUserName();
    }

    public function getEmail()
    {
        return $this->getItem('email') ?: $this->getVcs()->getUserEmail();
    }
}

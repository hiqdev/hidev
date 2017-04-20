<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Exception;
use hidev\base\File;
use hidev\helpers\Helper;
use yii\base\InvalidParamException;

/**
 * Init controller.
 * Builds .hidev/config.yml by template and params.
 */
class InitController extends TemplateController
{
    protected $_file = '.hidev/config.yml';

    public $name;
    public $vendor;
    public $package;

    public function prepareData($name)
    {
        $this->name = $name;
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
                $this->setItem('vendorRequire', $vendorPlugin);
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
        if (!$this->nocomposer) {
            $this->actionComposer();
        }

        return parent::actionPerform();
    }

    public function actionComposer()
    {
        $file = new File(['path' => 'composer.json']);
        $data = array_filter([
            'name'        => $this->name,
            'type'        => $this->getType(),
            'description' => $this->getTitle(),
            'keywords'    => preg_split('/\s*,\s*/', $this->getKeywords()),
            'require-dev' => $this->getPlugins(),
            'license'     => $this->getItem('license'),
        ]);
        $file->save($data);
        $this->setItem('norequire', true);
    }

    public function options($actionId)
    {
        return array_merge(parent::options($actionId), explode(',', 'namespace,headline,title,type,license,keywords,description,year,nick,author,email,novendor,norequire,nocomposer'));
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

    /**
     * Returns list of plugins in composer requirements format: name => version.
     * @return array
     */
    public function getPlugins()
    {
        if ($this->norequire) {
            return [];
        }
        $res = [
            'hiqdev/hidev-php' => '<2.0 || dev-master',
        ];
        if ($this->vendorRequire) {
            $res[$this->vendorRequire] = '<2.0 || dev-master';
        }

        return $res;
    }
}

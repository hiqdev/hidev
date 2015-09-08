<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;
use yii\base\InvalidParamException;

/**
 * Init goal to build files by template and params.
 */
class InitGoal extends TemplateGoal
{
    protected $_file = '.hidev/config.yml';

    protected $_fileType = 'template';

    public function actionPerform($name, $template = '.hidev/config')
    {
        list($vendor, $package) = explode('/', $name, 2);
        if (!$package || !$vendor) {
            throw new InvalidParamException('No vendor/package given');
        }
        $this->vendor   = $vendor;
        $this->package  = $package;
        $this->template = $template;

        if (!file_exists($this->dirname)) {
            mkdir($this->dirname);
        }

        return parent::actionPerform();
    }

    public function options($actionId)
    {
        return array_merge(parent::options($actionId), explode(',', 'label,title,type,keywords,year'));
    }

    public function getPackage()
    {
        return $this->getItem('package');
    }

    public function getTitle()
    {
        return $this->getItem('title') ?: Helper::titleize($this->package);
    }

    public function getLabel()
    {
        return $this->getItem('label') ?: Helper::id2camel($this->package);
    }

    public function getType()
    {
        return $this->getItem('type') ?: 'package';
    }

    public function getKeywords()
    {
        return $this->getItem('keywords') ?: implode(', ', explode('-', $this->package));
    }

    public function getYear()
    {
        return $this->getItem('year') ?: date('Y');
    }

}

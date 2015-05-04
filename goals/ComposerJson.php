<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;
use hiqdev\collection\Manager;

/**
 * Goal for composer.json
 */
class ComposerJson extends Template
{
    protected $_file = 'composer.json';

    public function init()
    {
        $package = $this->config->package;
        $sets = [
            'name'          => $this->fullName,
            'type'          => $this->type,
            'description'   => $package->title,
            'keywords'      => $package->keywords,
            'homepage'      => $package->homepage,
            'license'       => $package->license,
            'support'       => $this->support,
            'authors'       => $this->authors,
            'require'       => $this->require,
            'autoload'      => $this->autoload,
        ];
        $this->smartSet($sets, 'first');
    }

    public function setType($type)
    {
        $this->setItem('type', $type);
    }

    /**
     * Converts hidev type to composer type.
     * TODO package type can be different from composer type.
     */
    public function getType()
    {
        return $this->getRaw('type') ?: $this->config->package->type;
    }

    public function getFullName()
    {
        return $this->config->vendor->name . '/' . $this->config->package->name;
    }

    public function setSupport($support)
    {
        $this->setItem('support', $support);
    }

    public function getSupport()
    {
        $support = $this->getItem('support');
        $package = $this->config->package;
        $support->smartAdd([
            'email'     => $this->config->vendor->email,
            'source'    => $package->source,
            'issues'    => $package->issues,
            'wiki'      => $package->wiki,
            'forum'     => $package->forum,
        ],'first');
        return $support;
    }

    public function setAuthors($authors)
    {
        $this->setItem('authors', $authors);
    }

    public function getAuthors()
    {
        $res = [];
        foreach ($this->config->package->authors->getItems() as $name => $data) {
            $data['name'] = $name;
            $res[] = array_merge(compact('name'), $data);
        }
        return $res;
    }

}

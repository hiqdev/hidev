<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\goals;

use hiqdev\collection\Manager;

/**
 * Goal for composer.json
 */
class ComposerJsonGoal extends TemplateGoal
{
    protected $_file = 'composer.json';

    public function init()
    {
        $sets = [
            'name'          => $this->fullName,
            'type'          => $this->type,
            'description'   => $this->package->title,
            'keywords'      => $this->package->keywords,
            'homepage'      => $this->package->homepage,
            'license'       => $this->package->license,
            'support'       => $this->support,
            'authors'       => $this->authors,
            'require'       => $this->require,
            'autoload'      => $this->autoload,
        ];
        $this->smartSet($sets, 'first');
    }

    /**
     * Converts hidev type to composer type.
     * TODO package type can be different from composer type.
     */
    public function getType()
    {
        return $this->rawItem('type') ?: $this->package->type;
    }

    public function getFullName()
    {
        return $this->package->fullName;
    }

    public function getSupport()
    {
        $support = $this->getItem('support');
        $support->smartAdd([
            'email'     => $this->vendor->email,
            'source'    => $this->package->source,
            'issues'    => $this->package->issues,
            'wiki'      => $this->package->wiki,
            'forum'     => $this->package->forum,
        ],'first');
        return $support;
    }

    public function getAuthors()
    {
        $res = [];
        foreach ($this->package->authors->getItems() as $name => $data) {
            $data['name'] = $name;
            $res[] = array_merge(compact('name'), $data);
        }
        return $res;
    }

    public function getAutoload()
    {
        if (!$this->rawItem('autoload')) {
            $this->setItem('autoload', [
                'psr-4' => [
                    $this->package->namespace . '\\' => $this->package->src
                ]
            ]);
        }

        return $this->getItem('autoload');
    }
}

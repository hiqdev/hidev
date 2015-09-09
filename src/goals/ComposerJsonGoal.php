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

/**
 * Goal for composer.json.
 */
class ComposerJsonGoal extends TemplateGoal
{
    protected $_file = 'composer.json';

    public function actionLoad()
    {
        parent::actionLoad();
        $sets = [
            'name'        => $this->fullName,
            'type'        => $this->type,
            'description' => $this->package->title,
            'keywords'    => $this->package->keywords,
            'homepage'    => $this->package->homepage,
            'license'     => $this->package->license,
            'support'     => $this->support,
            'authors'     => $this->authors,
            'require'     => $this->require,
            'require-dev' => $this->get('require-dev'),
            'autoload'    => $this->autoload,
        ];
        $this->smartSet($sets, 'first');
        foreach (['require', 'require-dev'] as $k) {
            if (!$this->get($k)) {
                $this->delete($k);
            }
        }
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
        return array_merge(array_filter([
            'email'  => $this->vendor->email,
            'source' => $this->package->source,
            'issues' => $this->package->issues,
            'wiki'   => $this->package->wiki,
            'forum'  => $this->package->forum,
        ]), (array) $this->getItem('support'));
    }

    public function getAuthors()
    {
        $res = [];
        if ($this->package->authors) {
            foreach ($this->package->authors as $name => $data) {
                $data['name'] = $name;
                $res[]        = array_merge(compact('name'), $data);
            }
        }

        return $res;
    }

    public function getAutoload()
    {
        $autoload = $this->rawItem('autoload');
        $autoload['psr-4'] = [
            $this->package->namespace . '\\' => $this->package->src,
        ];
        $this->setItem('autoload', $autoload);

        return $autoload;
    }
}

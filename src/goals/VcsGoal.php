<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use Yii;

/**
 * Goal for VCS (Version Control Systems).
 */
class VcsGoal extends DefaultGoal
{
    public $lastTag = 'Under development';

    public $initTag = 'Development started';

    public $_ignore = [
        '.hidev/composer.json' => 'hidev internals',
        '.hidev/composer.lock' => 'hidev internals',
        '.hidev/vendor'        => 'hidev internals',
        '.*.swp'               => 'IDE & OS files',
        '.idea'                => 'IDE & OS files',
        'nbproject'            => 'IDE & OS files',
        '.buildpath'           => 'IDE & OS files',
        '.project'             => 'IDE & OS files',
        '.settings'            => 'IDE & OS files',
        'Thumbs.db'            => 'IDE & OS files',
        '.DS_Store'            => 'IDE & OS files',
    ];

    public function init()
    {
        parent::init();
        $vcsignore = Yii::$app->pluginManager->vcsignore;
        if ($vcsignore) {
            $this->setIgnore($vcsignore);
        }
    }

    public function setIgnore($items, $where = '')
    {
        $this->getIgnore()->setItems($items, $where);
    }

    public function getIgnore()
    {
        if (!is_object($this->_ignore)) {
            $this->_ignore = Yii::createObject([
                'class' => 'hiqdev\yii2\collection\Object',
                'items' => $this->_ignore,
            ]);
        }

        return $this->_ignore;
    }
}

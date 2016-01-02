<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

/**
 * Goal for VCS ignore files generation.
 */
class VcsignoreGoal extends FileGoal
{
    protected $_items = [
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

    public function actionLoad()
    {
        $items = $this->getFile()->load() ?: [];
        if ($items) {
            $this->vcs->setIgnore($items);
        }
    }

    public function actionSave()
    {
        return $this->getFile()->save($this->vcs->getIgnore());
    }
}

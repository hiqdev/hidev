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

/**
 * Goal for VCS ignore files generation.
 */
class VcsignoreGoal extends FileGoal
{
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

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

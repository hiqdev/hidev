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

/**
 * Controller for VCS ignore files generation.
 */
class VcsignoreController extends FileController
{
    /**
     * Load action.
     */
    public function actionLoad()
    {
        $items = [];
        foreach ($this->takeGoal('binaries')->getItems() as $binary) {
            if ($vcsignore = $binary->getVcsignore()) {
                $items[$vcsignore] = 'Binaries';
            }
        }
        unset($items['git.phar']);
        $this->takeVcs()->setIgnore($items);
        $items = $this->getFile()->load() ?: [];
        $this->takeVcs()->setIgnore($items);
    }

    /**
     * Save action.
     */
    public function actionSave()
    {
        $this->getFile()->save($this->takeVcs()->getIgnore());
    }
}

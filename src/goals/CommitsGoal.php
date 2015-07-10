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
 * Goal for reading and writing commits history to build CHANGELOG.md.
 */
class CommitsGoal extends FileGoal
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setDeps('vcs');
    }

    protected $_file = '.hidev/commits.md';

    protected $_fileType = 'commits';

    public function getHistory()
    {
        return $this->getFile()->getHandler()->getHistory();
    }
}

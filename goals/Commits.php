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

use Yii;

/**
 * Goal for reading and writing commits history to build CHANGELOG.md
 */
class Commits extends File
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setDeps('vcs');
    }

    protected $_file = '@config/commits.md';

    protected $_fileType = 'commits';

    public function getHistory()
    {
        return $this->getFile()->getHandler()->getHistory();
    }

}

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

/**
 * Goal for README
 */
class ChangelogGoal extends TemplateGoal
{
    protected $_fileType = 'changelog';

    public function init()
    {
        $this->setDeps('commits');
    }

    public function getTemplate()
    {
        return 'CHANGELOG';
    }

}

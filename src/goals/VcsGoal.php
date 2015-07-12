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

use Yii;

/**
 * Goal for VCS (Version Control Systems).
 */
class VcsGoal extends DefaultGoal
{
    public $lastTag = 'Under development';

    public $initTag = 'Development started';

    public $_ignore = [
        'runtime'               => 'runtime dir', /// XXX MOVE TO OTHER PLACE
        '.hidev/composer.json'  => 'hidev composer.json',
        '.*.swp'                => 'IDE & OS files',
        '.idea'                 => 'IDE & OS files',
        'nbproject'             => 'IDE & OS files',
        '.buildpath'            => 'IDE & OS files',
        '.project'              => 'IDE & OS files',
        '.settings'             => 'IDE & OS files',
        'Thumbs.db'             => 'IDE & OS files',
        '.DS_Store'             => 'IDE & OS files',
    ];

    public function setIgnore($items, $where = '')
    {
        $this->getIgnore()->setItems($items, $where);
    }

    public function getIgnore()
    {
        if (!is_object($this->_ignore)) {
            $this->_ignore = Yii::createObject([
                'class' => 'hiqdev\collection\Object',
                'items' => $this->_ignore,
            ]);
        }
        return $this->_ignore;
    }
}

<?php

/*
 * HiDev
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;

/**
 * Package part of the config.
 */
class Package extends \hiqdev\collection\Model
{
    public function rules()
    {
        return [
            ['type',            'safe'],
            ['name',            'safe'],
            ['label',           'safe'],
            ['title',           'safe'],
            ['description',     'safe'],
            ['license',         'safe'],
            ['keywords',        'safe'],
            ['namespace',       'safe'],
        ];
    }

    public function getLabel()
    {
        return $this->getItem('label') ?: ucfirst($this->name);
    }

    public function setLabel($label)
    {
        $this->setItem('label', $label);
    }

    public function getYears()
    {
        $cur = (integer)date('Y');
        $old = (integer)$this->year;
        return ($old && $old<$cur ? $this->year . '-' : '') . $cur;
    }
}

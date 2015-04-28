<?php

/*
 * HiDev
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\components;

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
            ['title',           'safe'],
            ['description',     'safe'],
            ['license',         'safe'],
            ['keywords',        'safe'],
            ['namespace',       'safe'],
        ];
    }
}

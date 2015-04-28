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
 * Vendor part of the config.
 */
class Vendor extends \hiqdev\collection\Model
{
    public function rules()
    {
        return [
            ['type',            'safe'],
            ['name',            'safe'],
            ['title',           'safe'],
            ['description',     'safe'],
        ];
    }
}

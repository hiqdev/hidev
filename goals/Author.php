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
 * Authors for the config.
 */
class Author extends \hiqdev\collection\Model
{
    public function rules()
    {
        return [
            ['name',            'safe'],
            ['role',            'safe'],
            ['email',           'safe'],
            ['homepage',        'safe'],
        ];
    }

}

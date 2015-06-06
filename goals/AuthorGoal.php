<?php

/*
 * HiDev
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\goals;

/**
 * Authors for the config.
 */
class AuthorGoal extends \hiqdev\collection\Model
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

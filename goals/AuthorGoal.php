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

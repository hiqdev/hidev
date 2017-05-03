<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

/**
 * Git component.
 */
class Git extends AbstractVcs
{
    public $ignorefile = '.gitignore';

    /**
     * @var string current tag
     */
    protected $tag;

    public function getUserName()
    {
        return trim(`git config --get user.name`);
    }

    public function getUserEmail()
    {
        return trim(`git config --get user.email`);
    }

    public function getYear()
    {
        $date = `git log --reverse --pretty=%ai | head -n 1`;
        $year = $date ? date('Y', strtotime($date)) : '';

        return $year;
    }

    public function commit($message)
    {
        return $this->passthru('git', ['commit', '-am', $message]);
    }

    public function tag($tag)
    {
        return $this->passthru('git', ['tag', $tag]);
    }

    public function push()
    {
        return $this->passthru('git', ['push', '--tags']);
    }
}

<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Git.
 */
class GitController extends \hidev\base\Controller
{
    protected $_before = ['.gitignore'];

    /**
     * @var string current tag
     */
    protected $tag;

    public function actionRelease($version = null)
    {
        $version = $this->takeGoal('version')->getVersion($version);
        $message = "version bump to $version";
        $this->actionCommit($message);
        $this->actionTag($version);

        return $this->actionPush();
    }

    public function actionCommit($message)
    {
        return $this->passthru('git', ['commit', '-am', $message]);
    }

    public function actionTag($tag)
    {
        return $this->passthru('git', ['tag', $tag]);
    }

    public function actionPush()
    {
        return $this->passthru('git', 'push', '--tags');
    }

}

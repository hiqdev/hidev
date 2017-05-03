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
        $version = $this->take('version')->getVersion($version);
        $message = "version bump to $version";
        $this->getComponent()->commit($message);
        $this->getComponent()->tag($version);

        return $this->getComponent()->push();
    }

    public function actionCommit($message)
    {
        return $this->getComponent()->commit($message);
    }

    public function actionTag($tag)
    {
        return $this->getComponent()->tag($tag);
    }

    public function actionPush()
    {
        return $this->getComponent()->push();
    }

    public function getComponent()
    {
        return $this->take('git');
    }
}

<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\console;

/**
 * Goal for GitHub.
 */
class GithubController extends CommonController
{
    /**
     * Create the repo on GitHub.
     * If name not given, repo for current project created.
     * @param string $repo full name
     * @return int exit code
     */
    public function actionCreate(string $repo = null)
    {
        return $this->getComponent()->createRepo($repo);
    }

    /**
     * Clone repo from github.
     * TODO this action must be run without `start`.
     * @param string $repo full name vendor/package
     * @return int exit code
     */
    public function actionClone(string $repo)
    {
        return $this->getComponent()->cloneRepo($repo);
    }

    /**
     * Checks if repo exists.
     * @param string $repo full name vendor/package defaults to this repo name
     * @return int exit code
     */
    public function actionExists($repo = null)
    {
        return $this->getComponent()->existsRepo($repo);
    }

    /**
     * Creates github release for current project repo.
     * @param string $release version number
     */
    public function actionRelease($release = null)
    {
        return $this->getComponent()->releaseRepo($repo);
    }

    public function getComponent()
    {
        return $this->take('github');
    }
}

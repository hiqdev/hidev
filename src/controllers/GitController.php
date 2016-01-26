<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Yii;

/**
 * Controller for Git.
 */
class GitController extends VcsController
{
    protected $_before = ['.gitignore'];

    /**
     * @var array VCS tags
     */
    protected $_tags = [];

    public function getTags()
    {
        return $this->_tags;
    }

    public function loadTags()
    {
        exec("git log --date=short --tags --simplify-by-decoration --pretty='format:%cd %d'", $logs);
        foreach ($logs as $log) {
            preg_match('/^([0-9-]+)\s*(\(.*\))?$/', $log, $m);
            $this->_tags[$this->matchTag($m[2]) ?: $this->initTag] = $m[1];
        }
    }

    /**
     * @var string current tag
     */
    protected $tag;

    /**
     * @var array VCS history
     */
    protected $_history = [];

    /**
     * @var array all the commits
     */
    protected $_commits = [];

    public function getCommits()
    {
        return $this->_commits;
    }

    public function getHistory()
    {
        return $this->_history;
    }

    public function addHistory($commit)
    {
        $this->tag                         = $this->matchTag($commit['tag']) ?: $this->tag;
        $commit['tag']                     = $this->tag;
        $hash                              = (string) $commit['hash'];
        $this->_commits[$hash]             = $commit;
        $this->_history[$this->tag][$hash] = $commit;
    }

    public function loadHistory()
    {
        exec("git log --date=short --pretty='format:%h %ad %ae %s |%d'", $logs);
        $this->tag = $this->lastTag;
        foreach ($logs as $log) {
            if (!preg_match('/^(\w+) ([0-9-]+) (\S+) (.*?)\s+\| ?(\([^\(\)]+\))?$/', $log, $m)) {
                Yii::error('failed parse git log');
                die();
            }
            $this->addHistory([
                'hash'    => $m[1],
                'date'    => $m[2],
                'email'   => $m[3],
                'comment' => $m[4],
                'tag'     => $m[5],
            ]);
        }
    }

    public function matchTag($str)
    {
        preg_match('/^\((.*?)\)$/', $str, $m);
        $refs = explode(', ', $m[1]);
        foreach ($refs as $ref) {
            if (preg_match('/^tag: (.*)$/', $ref, $m)) {
                return $m[1];
            }
        }

        return false;
    }

    public function actionLoad()
    {
        $this->loadTags();
        $this->loadHistory();
    }

    public function actionPush()
    {
        return $this->passthru('git', 'push');
    }

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
        $tags = $this->getTags();
        if ($tags) {
            $date = array_pop($this->getTags());
        } else {
            $date = `git log --reverse --pretty=%ai | head -n 1`;
        }
        $year = $date ? date('Y', strtotime($date)) : '';

        return $year;
    }
}

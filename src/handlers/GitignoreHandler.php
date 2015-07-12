<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\handlers;

use Yii;

/**
 * Handler for commits.md file.
 */
class GitignoreHandler extends BaseHandler
{
    public $type = 'gitignore';

    public function parsePath($path)
    {
        $items = [];
        $lines = is_file($path) ? $this->readArray($path) : [];
        foreach ($lines as $str) {
            $str = trim($str);
            if (!$str) {
                continue;
            }
            if ($str[0] === '#') {
                $comment = trim(substr($str,1));
            } else {
                $items[$str] = $comment;
            }
        }

        return $items;
    }

    public function addHistory($commit, $front = false)
    {
        $tag    = $commit['tag'];
        $note   = $commit['note'];
        $hash   = $commit['hash'];
        $render = static::renderCommit($commit);
        $hashes = &$this->_history[$tag][$note];
        $hashes = (array) $hashes;
        if ($front) {
            $hashes = [$hash => [$render]] + $hashes;
        } else {
            $hashes[$hash][] = $render;
        }
    }

    public function hasHistory($tag)
    {
        return array_key_exists($tag, $this->_history);
    }

    public function getHistory()
    {
        return $this->_history;
    }

    public function render($items)
    {
        foreach ($items as $item => $comment) {
            $comments[$comment] .= $item . "\n";
        }

        foreach ($comments as $comment => $items) {
            $res .= static::renderComment($comment) . $items;
        }

        return $res;
    }

    public static function renderComment($comment)
    {
        return "\n" . ($comment[0]==='#' ? '' : '# ') . "$comment\n";
    }

}

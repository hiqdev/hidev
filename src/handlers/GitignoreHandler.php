<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

/**
 * Handler for commits.md file.
 */
class GitignoreHandler extends BaseHandler
{
    public $type = 'gitignore';

    public function parsePath($path, $minimal = null)
    {
        $items = [];
        $lines = is_file($path) ? $this->readArray($path) : [];
        foreach ($lines as $str) {
            $str = trim($str);
            if (!$str) {
                continue;
            }
            if ($str[0] === '#') {
                $comment = trim(substr($str, 1));
            } else {
                $items[$str] = $comment;
            }
        }

        return $items;
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

        return ltrim($res);
    }

    public static function renderComment($comment)
    {
        return "\n#" . ($comment[0] === '#' ? '' : ' ') . "$comment\n";
    }
}

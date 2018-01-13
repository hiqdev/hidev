<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

/**
 * Handler for `.gitignore` file.
 */
class GitignoreHandler extends BaseHandler
{
    public $type = 'gitignore';

    public function parsePath($path, $minimal = null)
    {
        $items = [];
        $lines = is_file($path) ? $this->readArray($path) : [];
        $comment = '';
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

    public function render($items)
    {
        $comments = [];
        foreach ($items as $item => $comment) {
            $comments[$comment][$item] = $item;
        }

        $res = '';
        foreach ($comments as $comment => $items) {
            ksort($items);
            $res .= static::renderComment($comment) . implode("\n", $items) . "\n";
        }

        return ltrim($res);
    }

    public static function renderComment($comment)
    {
        return "\n#" . ($comment[0] === '#' ? '' : ' ') . "$comment\n";
    }
}

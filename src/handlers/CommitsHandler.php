<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use Yii;

/**
 * Handler for commits.md file.
 */
class CommitsHandler extends BaseHandler
{
    public $type = 'commits';

    protected $_tag;
    protected $_note;
    protected $_hash;
    protected $_history = [];
    protected $_commits = [];

    public function getTag()
    {
        return $this->_tag;
    }

    public function getNote()
    {
        return $this->_note;
    }

    public function getHash()
    {
        return $this->_hash;
    }

    public function setTag($tag)
    {
        $this->_tag  = $tag;
        $this->_note = '';
        $this->_hash = '';
    }

    public function setNote($note)
    {
        $this->_note = $note;
        $this->_hash = '';
    }

    public function setHash($hash)
    {
        $this->_hash = $hash;
    }

    public function addTag($tag, $label = null)
    {
        $this->tag = $tag;
        $ref       = &$this->_history[$tag]['tag'];
        $ref       = $label ?: $ref ?: $tag;
    }

    public function addNote($note, $label = null)
    {
        $this->note = $note;
        $ref        = &$this->_history[$this->tag][$note]['note'];
        $ref        = $label ?: $ref ?: $note;
    }

    public function addHash($hash, $label)
    {
        $this->_hash                    = $hash;
        $this->_commits[(string) $hash] = $label;
    }

    public function hasCommit($hash)
    {
        return array_key_exists((string) $hash, $this->_commits);
    }

    public function parsePath($path, $minimal = null)
    {
        $this->tag      = static::getVcs()->lastTag;
        $this->_history = [
            $this->tag => [],
        ];
        $lines = is_file($path) ? $this->readArray($path) : [];
        foreach ($lines as $str) {
            $str = rtrim($str);
            ++$no;
            if (!$str || $no < 3) {
                continue;
            }
            if (preg_match('/^# /', $str)) {
                continue;
            };
            if (preg_match('/^## (.*)$/', $str, $m)) {
                $label = $m[1];
                foreach ([static::getVcs()->lastTag, static::getVcs()->initTag] as $z) {
                    if (stripos($label, $z) !== false) {
                        $this->addTag($z, $label);
                        continue 2;
                    }
                }
                preg_match('/^(\S+)\s*(.*)$/', $label, $m);
                $this->addTag($m[1], $label);
                continue;
            }
            if (preg_match('/^- (.*)$/', $str, $m)) {
                $this->addNote($m[1]);
                continue;
            }
            if (preg_match('/^\s+- ([0-9a-fA-F]{7})/', $str, $m)) {
                $this->addHash($m[1], $str);
            }
            $this->_history[$this->tag][$this->note][$this->hash][] = $str;
        }

        return $this->_history;
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

    public function render($data)
    {
        $res = static::renderHeader('commits history');

        foreach (array_reverse(static::getVcs()->commits, true) as $hash => $commit) {
            if ($this->hasCommit($hash)) {
                continue;
            }
            $this->addHistory($commit, true);
        }
        if (!$this->hasHistory(static::getVcs()->initTag)) {
            $this->addHistory(['tag' => static::getVcs()->initTag]);
        }

        foreach ($this->_history as $tag => $notes) {
            $tag = static::arrayPop($notes, 'tag') ?: $tag;
            $new = static::arrayPop($notes, '') ?: [];
            $res .= static::renderTag($tag);
            foreach ($new as $hash => $lines) {
                $res .= static::renderLines($lines);
            }
            foreach ($notes as $note => $cs) {
                $note = static::arrayPop($cs, 'note');
                $res .= static::renderNote($note);
                foreach ($cs as $hash => $lines) {
                    $res .= static::renderLines($lines);
                }
            }
        }

        return $res;
    }

    public static function arrayPop(&$array, $key)
    {
        $res = $array[$key];
        unset($array[$key]);

        return $res;
    }

    public static function renderNote($note)
    {
        return "- $note\n";
    }

    public static function renderLines(array $lines)
    {
        $res = implode("\n", array_filter($lines));

        return $res ? $res . "\n" : '';
    }

    public static function renderCommit($commit)
    {
        return static::skipCommit($commit) ? '' : "    - $commit[hash] $commit[date] $commit[comment] ($commit[email])";
    }

    public static function skipCommit($commit)
    {
        $comment = $commit['comment'];

        static $equals = [
            ''      => 1,
            'minor' => 1,
        ];
        if ($equals[$comment]) {
            return true;
        }

        static $starts = [
            'version bump',
            'bumped version',
            "merge branch 'master'",
        ];
        foreach ($starts as $start) {
            if (strtolower(substr($comment, 0, strlen($start))) === $start) {
                return true;
            }
        }

        return false;
    }

    public static function renderTag($tag)
    {
        if (strpos($tag, ' ') === false || $tag === static::getVcs()->initTag) {
            $tag .= static::renderDate(static::getVcs()->tags[$tag]);
        }

        return "\n## $tag\n\n";
    }

    public static function renderDate($date)
    {
        return $date ? date(' Y-m-d', strtotime($date)) : '';
    }

    public static function renderHeader($string)
    {
        $header = Yii::$app->config->package->fullName . ' ' . $string;

        return $header . "\n" . str_repeat('-', mb_strlen($header, Yii::$app->charset)) . "\n";
    }

    public static function getVcs()
    {
        return Yii::$app->config->vcs;
    }
}

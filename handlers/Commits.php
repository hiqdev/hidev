<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\handlers;

use Yii;

/**
 * Handler for commits.md file.
 */
class Commits extends Base
{
    public $type = 'commits';

    protected $_tag;
    protected $_note;
    protected $_commit;
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

    public function getCommit()
    {
        return $this->_commit;
    }

    public function setTag($tag)
    {
        $this->_tag = $tag;
        $this->_note = '';
        $this->_commit = '';
    }

    public function setNote($note)
    {
        $this->_note = $note;
        $this->_commit = '';
    }

    public function setCommit($commit)
    {
        $this->_commit = $commit;
    }

    public function addTag($tag, $label = null)
    {
        $this->tag = $tag;
        $ref = &$this->_history[$tag]['tag'];
        $ref = $label ?: $ref ?: $tag;
    }

    public function addNote($note, $label = null)
    {
        $this->note = $note;
        $ref = &$this->_history[$this->tag][$note]['note'];
        $ref = $label ?: $ref ?: $note;
    }

    public function addCommit($commit, $label)
    {
        $this->commit = $commit;
        $this->_commits[$commit] = $label;
    }

    public function hasCommit($hash)
    {
        return array_key_exists($hash, $this->_commits);
    }

    public function parsePath($path)
    {
        $this->_history = [];
        $this->tag = static::getVcs()->lastTag;
        $lines = is_file($path) ? $this->readArray($path) : [];
        foreach ($lines as $str) {
            $str = rtrim($str);
            $no++;
            if (!$str || $no<3) {
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
                $this->addCommit($m[1], $str);
            }
            $this->_history[$this->tag][$this->note][$this->commit][] = $str;
        }

        return $this->_history;
    }

    public function addHistory($commit)
    {
        $tag        = $commit['tag'];
        $note       = $commit['note'];
        $hash       = $commit['hash'];
        $this->_history[$tag][$note][$hash][] = static::renderCommit($commit);
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

        foreach ($this->goal->vcs->commits as $hash => $commit) {
            if ($this->hasCommit($hash)) {
                continue;
            }
            $this->addHistory($commit);
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
        static $skips = [
            ''      => 1,
            'minor' => 1,
        ];
        return $skips[$commit['comment']] ? '' : "    - $commit[hash] $commit[date] $commit[comment] ($commit[email])";
    }

    public static function renderTag($tag)
    {
        if (strpos($tag, ' ')===false || $tag===static::getVcs()->initTag) {
            $tag .= static::renderDate(static::getVcs()->tags[$tag]);
        }
        return "\n## $tag\n\n";
    }

    public static function renderDate($date)
    {
        return $date ? date(' F j, Y', strtotime($date)) : '';
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

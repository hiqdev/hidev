<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\base;

/**
 * Handler for commits history
 */
class History
{
    public $lastTag;
    public $initTag;

    public function init()
    {
        parent::init();
        $this->lastTag = $this->goal->vcs->lastTag;
        $this->initTag = $this->goal->vcs->initTag;
    }

    protected $_tag;
    protected $_note;
    protected $_commit;
    protected $_history;
    protected $_commits;

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

    public function addTag($tag, $label)
    {
        $this->tag = $tag;
        $this->_history[$this->tag]['tag'] = $label ?: $tag;
    }

    public function addNote($note, $label = null)
    {
        $this->note = $note;
        $this->_history[$this->tag][$note]['note'] = $label ?: $note;
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

        $this->tag = $this->lastTag;
        foreach ($this->readArray($path) as $str) {
            $str = rtrim($str);
            if (!$str) {
                continue;
            }
            if (preg_match('/^# /', $str)) {
                continue;
            };
            if (preg_match('/^## (.*)$/', $str, $m)) {
                $label = $m[1];
                foreach ([$this->lastTag, $this->initTag] as $z) {
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
        $this->_history[$tag][$note][$hash] = $commit;
    }

    public function getHistory()
    {
        return $this->_history;
    }

    public function renderPath($path, $data)
    {
        $res = '# ' . $this->goal->package->fullName . " commits history\n";

        foreach ($this->goal->vcs->commits as $hash => $commit) {
            if ($this->hasCommit($hash)) {
                continue;
            }
            $this->addHistory($commit);
        }

        foreach ($this->_history as $tag => $notes) {
            $tag = $this->arrayPop($notes, 'tag');
            $new = $this->arrayPop($notes, '');
            $res .= $this->renderTag($tag);
            if ($new) {
                foreach ($new as $hash => $commit) {
                    $res .= $this->renderCommit($commit);
                }
            }
            foreach ($notes as $note => $cs) {
                $note = $this->arrayPop($cs, 'note');
                $res .= $this->renderNote($note);
                foreach ($cs as $hash => $lines) {
                    $res .= implode("\n", $lines) . "\n";
                }
            }
        }

        return $res;
    }

    public function arrayPop(&$array, $key)
    {
        $res = $array[$key];
        unset($array[$key]);
        return $res;
    }

    public function renderNote($note)
    {
        return "- $note\n";
    }

    public function renderCommit($commit)
    {
        return "    - $commit[hash] $commit[date] $commit[comment] ($commit[email])\n";
    }

    public function renderTag($tag)
    {
        if (strpos($tag, ' ')===false) {
            $tag .= $this->renderDate($this->goal->vcs->tags[$tag]);
        }
        return "\n## $tag\n\n";
    }

    public function renderDate($date)
    {
        return $date ? date(' F j, Y', strtotime($date)) : '';
    }

}

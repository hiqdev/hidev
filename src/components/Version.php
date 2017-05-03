<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

/**
 * `version` file component.
 */
class Version extends \hidev\base\ConfigFile
{
    protected $_file = 'version';

    protected $fileRelease;
    protected $fileHash;
    protected $release;
    protected $date;
    protected $time;
    protected $zone;
    protected $hash;
    protected $commit;
    protected $branch;

    public function init()
    {
        if ($this->exists()) {
            $this->parseFile();
            $this->fileRelease = $this->release;
            $this->fileHash = $this->hash;
        }
    }

    public function parseFile()
    {
        $line = trim($this->getFile()->read());
        list($tmp, $this->release, $this->date, $this->time, $this->zone, $this->hash) = explode(' ', $line);
        $this->parseRelease();
    }

    public function parseRelease()
    {
        if (preg_match('/^(\w+)-([0-9\.]+)-(\S+)/', $this->release, $matches)) {
            $this->release  = $matches[1];
            $this->branch   = $matches[2];
        }
    }

    public function renderFile()
    {
        return implode(' ', [$this->getName(), $this->renderRelease(), $this->date, $this->time, $this->zone, $this->hash]);
    }

    public function renderRelease()
    {
        if ($this->branch) {
            return implode('-', [$this->release, $this->branch, substr($this->hash, 0, 7)]);
        } else {
            return $this->release;
        }
    }

    public function update($release)
    {
        $this->load();
        $this->setRelease($release);
        $this->save();
    }

    public function load()
    {
        $line = trim($this->exec('git', ['log', '-n', '1', '--pretty=%ai %H %s'])[0]);
        list($this->date, $this->time, $this->zone, $this->hash, $this->commit) = explode(' ', $line, 5);
        if ($this->hash !== $this->fileHash) {
            $this->branch  = $this->release;
            $this->release = 'dev';
        }
    }

    public function save()
    {
        $this->getFile()->write($this->renderFile() . "\n");
    }

    public function setRelease($release = null, $branch = null)
    {
        $this->setBranch($branch);
        $this->release = $this->getRelease($release);
    }

    public function getRelease($release = null)
    {
        return $release ?: $this->release ?: 'dev';
    }

    public function setBranch($branch)
    {
        if (isset($branch)) {
            $this->branch = $branch;
        }
    }

    public function getAbspath()
    {
        return $this->getFile()->getAbspath();
    }

    public function getName()
    {
        return $this->take('package')->name;
    }
}

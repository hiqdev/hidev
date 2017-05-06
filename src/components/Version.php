<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
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

    protected $parsedRelease;
    protected $parsedHash;
    protected $parsedName;
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
            $this->parsedRelease = $this->release;
            $this->parsedHash = $this->hash;
        }
    }

    public function parseFile()
    {
        $line = trim($this->getFile()->read());
        list($this->parsedName, $this->release, $this->date, $this->time, $this->zone, $this->hash) = explode(' ', $line);
        $this->parseRelease();
    }

    public function parseRelease()
    {
        if (preg_match('/^(\S+)-(\S+)-(\S+)/', $this->release, $matches)) {
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
        if ($this->release === 'dev') {
            return implode('-', [$this->release, $this->getBranch(), substr($this->hash, 0, 7)]);
        } else {
            return $this->release;
        }
    }

    public function getBranch()
    {
        return $this->branch ?: 'master';
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
        if ($this->hash !== $this->parsedHash) {
            if ($this->release !== 'dev') {
                $this->branch = $this->release;
            }
            $this->release = 'dev';
        }
    }

    public function save()
    {
        $this->getFile()->write($this->renderFile() . "\n");
    }

    public function setRelease($release = null, $branch = '')
    {
        $this->release = $this->getRelease($release);
        $this->setBranch($branch, $this->release);
    }

    public function getRelease($release = null)
    {
        return $release ?: $this->release ?: 'dev';
    }

    public function setBranch($branch, $release = null)
    {
        if (isset($branch) && $release !== 'dev') {
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

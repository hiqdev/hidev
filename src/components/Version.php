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

    public function init()
    {
        if ($this->exists()) {
            $line = trim($this->getFile()->read());
            list($this->release, $this->date, $this->time, $this->zone, $this->hash) = explode(' ', $line);
            $this->fileRelease = $this->release;
            $this->fileHash = $this->hash;
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
            $this->release = implode('-', ['dev', $this->release, substr($this->hash, 0, 7)]);
        }
    }

    public function save()
    {
        $this->getFile()->write(implode(' ', [$this->release, $this->date, $this->time, $this->zone, $this->hash]) . "\n");
    }

    public function setRelease($release = null)
    {
        $this->release = $this->getRelease($release);
    }

    public function getRelease($release = null)
    {
        return $release ?: $this->release ?: 'dev';
    }

    public function pretty()
    {
        return implode(' ', [$this->release, $this->date, $this->time, $this->hash]);
    }

    public function getAbspath()
    {
        return $this->getFile()->getAbspath();
    }
}

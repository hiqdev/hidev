<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use hidev\modifiers\ModifierInterface;
use yii\base\InvalidConfigException;

class Binary extends \yii\base\Object
{
    /**
     * @var BinariesController parent controller
     */
    public $controller;

    /**
     * @var string command name, eg.: phpunit, composer
     */
    public $name;

    /**
     * @var string full path to the binary, eg.: /usr/bin/git
     */
    protected $_path;

    /**
     * @var string full command to run the binary, possibly with added command runner, eg.: /usr/bin/env php /home/user/command.phar
     */
    protected $_command;

    /**
     * @var string package full name, e.g. pytest
     */
    public $package;

    /**
     * @var string package version constraint, e.g. ^1.1
     */
    public $version;

    /**
     * @var string installer URL
     */
    public $installer;

    /**
     * @var array installer options
     */
    public $installer_options = [];

    /**
     * @var string URL to download binary
     */
    public $download;

    /**
     * @var string filename to be added to VCS ignore file
     */
    protected $_vcsignore;

    /**
     * Prepares and runs with passthru, returns exit code.
     * @param string|array $args
     * @return int exit code
     */
    public function passthru($args = [])
    {
        passthru($this->prepareCommand($args), $exitcode);

        return $exitcode;
    }

    /**
     * Prepares and runs with exec, returns stdout array.
     * @param string|array $args
     * @param bool $returnExitCode default false
     * @return array|int stdout or exit code
     */
    public function exec($args = [], $returnExitCode = false)
    {
        exec($this->prepareCommand($args), $array, $exitcode);

        return $returnExitCode ? $exitcode : $array;
    }

    /**
     * Prepare full command line ready for execution.
     * @param string|array $args
     * @return string
     */
    public function prepareCommand($args)
    {
        $command = $this->getCommand();
        if (is_string($args)) {
            return $command . ' ' . trim($args);
        }

        foreach ($args as $arg) {
            if ($arg instanceof ModifierInterface) {
                $command = $arg->modify($command);
            } else {
                $command .= ' ' . escapeshellarg($arg);
            }
        }

        return $command;
    }

    public function install()
    {
        throw new InvalidConfigException('Don\'t know how to install ' . $this->name);
    }

    /**
     * Setter for path.
     * @param string $value the path
     */
    public function setPath($value)
    {
        $this->_path = $value;
    }

    /**
     * Getter for path.
     * @return string
     */
    public function getPath()
    {
        if (!$this->_path) {
            $this->_path = $this->detectPath($this->name);
        }

        return $this->_path;
    }

    /**
     * Detects how to run the binary with `which` utility.
     * @param string $name
     * @return string path to the binary
     */
    public function detectPath($name)
    {
        return exec('which ' . $name) ?: null;
    }

    /**
     * Setter for command.
     * @param string $value the command
     */
    public function setCommand($value)
    {
        $this->_command = $value;
    }

    /**
     * @return string full command to run the binary
     */
    public function getCommand()
    {
        if ($this->_command === null) {
            $this->_command = $this->detectCommand($this->getPath());
        }

        return $this->_command;
    }

    /**
     * Detects command to run the given path, e.g. /usr/bin/env php /the/dir/command.phar.
     * @return string path to the binary
     */
    public function detectCommand($path)
    {
        if (!$path) {
            $this->install();
            $path = $this->getPath();
        }
        if (!$path || !file_exists($path)) {
            throw new InvalidConfigException('Failed to find how to run ' . $this->name);
        }

        return $path;
    }

    public function setVcsignore($value)
    {
        $this->_vcsignore = $value;
    }

    public function getVcsignore()
    {
        return $this->_vcsignore;
    }
}

<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use Yii;

/**
 * Getters trait.
 */
trait GettersTrait
{
    protected $_view;

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = $this->getApp()->getView();
        }

        return $this->_view;
    }

    public function take($id)
    {
        return $this->getApp()->get($id);
    }

    public function getApp()
    {
        return Yii::$app;
    }

    /**
     * Runs given binary with given arguments.
     * Command output passes unchanged to console.
     * Returns exit code.
     * @param string $name
     * @param array|string $args
     * @return int exit code
     */
    public function passthru($name, $args = [])
    {
        return $this->take('binaries')->passthruBinary($name, $args);
    }

    /**
     * Runs given binary with given arguments. Returns stdout array.
     * @param string $name
     * @param string $args
     * @param bool $returnExitCode, default false
     * @return array|int stdout or exitcode
     */
    public function exec($name, $args = '', $returnExitCode = false)
    {
        return $this->take('binaries')->execBinary($name, $args, $returnExitCode);
    }

    public function execCode($name, $args = '')
    {
        return $this->take('binaries')->execBinary($name, $args, true);
    }
}

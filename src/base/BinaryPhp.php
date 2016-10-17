<?php

/*
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use Yii;

class BinaryPhp extends Binary
{
    /**
     * Detects how to run the binary.
     * Searches in this order:
     * 1. PHAR in project's root directory
     * 2. projects's vendor/bin directory
     * 3. composer global vendor/bin directory.
     *
     * @param string $name
     * @return string path to the binary
     */
    public function detectPath($name)
    {
        $paths = [Yii::getAlias("@root/$name.phar", false), Yii::getAlias("@root/vendor/bin/$name", false), "$_SERVER[HOME]/.composer/vendor/bin/$name"];
        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return parent::detectPath($name);
    }

    /**
     * Detect command execution string.
     * @param mixed $path
     * @return string
     */
    public function detectCommand($path)
    {
        $path = parent::detectCommand($path);

        return is_executable($path) ? $path : '/usr/bin/env php ' . $path;
    }

    public function install()
    {
        if ($this->installer) {
            passthru('/usr/bin/env wget ' . escapeshellarg($this->installer) . ' -O- | /usr/bin/env php', $exitcode);
        } elseif ($this->download) {
            $dest = Yii::getAlias('@root/' . $this->name . '.phar', false);
            passthru('/usr/bin/env wget ' . escapeshellarg($this->download) . ' -O ' . $dest, $exitcode);
        } else {
            return parent::install();
        }

        return $exitcode;
    }

    public function getVcsignore()
    {
        return $this->name . '.phar';
    }
}

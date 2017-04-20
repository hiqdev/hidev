<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use Yii;

class BinaryPython extends Binary
{
    /**
     * Detects how to run the binary.
     * Searches in this order:
     * 1. exexcutable in project's root directory
     * 2. XXX ??? vendor directory
     * 3. /home/user/.local/bin.
     *
     * @param string $name
     * @return string path to the binary
     */
    public function detectPath($name)
    {
        $paths = [
            Yii::getAlias("@root/$name", false),
            Yii::getAlias("@root/env/bin/$name", false),
            "$_SERVER[HOME]/.local/bin/$name",
        ];
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

        return is_executable($path) ? $path : '/usr/bin/env python ' . $path;
    }

    public function install()
    {
        if ($this->installer) {
            passthru('/usr/bin/env wget ' . escapeshellarg($this->installer) . ' -O- | /usr/bin/env python', $exitcode);
        } elseif ($this->download) {
            $dest = Yii::getAlias('@root/' . $this->name, false);
            passthru('/usr/bin/env wget ' . escapeshellarg($this->download) . ' -O ' . $dest, $exitcode);
        } else {
            $args = ['install'];
            if (!$_SERVER['VIRTUAL_ENV']) {
                $args[] = '--user';
            }
            $args[] = $this->package;
            $exitcode = $this->controller->passthru('pip', $args);
        }

        return $exitcode;
    }
}

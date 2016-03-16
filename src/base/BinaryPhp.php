<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
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
     * @var string package full name, e.g. fabpot/php-cs-fixer
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
     * @var string URL to download PHAR
     */
    public $download;

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
        $paths = [Yii::getAlias("@prjdir/$name.phar", false), Yii::getAlias("@prjdir/vendor/bin/$name", false), "$_SERVER[HOME]/.composer/vendor/bin/$name"];
        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return parent::detectPath($name);
    }

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
            $dest = Yii::getAlias('@prjdir/' . $this->name . '.phar', false);
            passthru('/usr/bin/env wget ' . escapeshellarg($this->download) . ' -O ' . $dest, $exitcode);
        } else {
            return parent::install();
        }

        return $exitcode;
    }
}

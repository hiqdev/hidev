<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\helpers;

use Yii;

/**
 * Hidev FileHelper.
 */
class FileHelper
{
    /**
     * Writes given content to the file.
     * Doesn't touch file if it has exactly same content.
     * Creates intermediate directories when necessary.
     * @param string $path
     * @param string $content
     * @return bool true if file was changed
     */
    public static function write($path, $content)
    {
        $path = Yii::getAlias($path);
        if (is_file($path) && file_get_contents($path) === $content) {
            return false;
        }

        static::mkdir(dirname($path));
        if (!is_writable($path) && posix_isatty(0)) {
            $tmp = tempnam('/tmp', 'hidev.');
            file_put_contents($tmp, $content);
            chmod($tmp, 0644);
            passthru("sudo cp $tmp $path");
            unlink($tmp);
        } else {
            file_put_contents($path, $content);
        }
        Yii::warning('Written file: ' . $path, 'file');

        return true;
    }

    /**
     * Creates directory if not exists.
     * Creates intermediate directories when necessary.
     * @param string $path
     * @return bool true if directory did not exist and was created
     */
    public static function mkdir($path)
    {
        $path = Yii::getAlias($path);
        $path = rtrim(trim($path), '/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            Yii::warning('Created dir:  ' . $path . '/', 'file');

            return true;
        }

        return false;
    }

    /**
     * Creates a symlink.
     * @param string $src existing source path
     * @param string $dst destionation path to be created
     * @return true on success or false on failure
     */
    public static function symlink($src, $dst)
    {
        if (!is_writable($dst) && posix_isatty(0)) {
            passthru("sudo ln -s $src $dst", $retval);
            return $retval === 0;
        } else {
            return symlink($this->path, $dest);
        }
    }
}

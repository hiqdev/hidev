<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
 */

namespace hidev\helpers;

use Yii;
use yii\log\Logger;

/**
 * Hidev FileHelper.
 */
class FileHelper
{
    /**
     * Reads and returns file content.
     * @param string $path
     * @return string|false false if can't read
     */
    public static function read($path, $die = true)
    {
        $path = Yii::getAlias($path);

        if (is_readable($path)) {
            return file_get_contents($path);
        }

        $level = $die ? Logger::LEVEL_ERROR : Logger::LEVEL_WARNING;
        Yii::getLogger()->log('Failed to read file: ' . $path, $level, 'file');

        return false;
    }

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
        try {
            file_put_contents($path, $content);
        } catch (\Exception $e) {
            if (posix_isatty(0)) {
                $tmp = tempnam('/tmp', 'hidev.');
                file_put_contents($tmp, $content);
                chmod($tmp, 0644);
                passthru("sudo cp $tmp $path");
                unlink($tmp);
            }
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
     * @return true on success and false/null on failure
     */
    public static function symlink($src, $dst)
    {
        try {
            // remove old link
            if (is_link($dst) && readlink($dst) !== $src) {
                unlink($dst);
            }

            if (!is_link($dst)) {
                return symlink($src, $dst);
            }
        } catch (\Exception $e) {
            if (posix_isatty(0)) {
                passthru("sudo ln -s $src $dst", $retval);

                return $retval === 0;
            }
        }
    }
}

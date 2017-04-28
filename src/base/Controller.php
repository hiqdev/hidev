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

/**
 * Basic controller.
 */
abstract class Controller extends \yii\console\Controller
{
    use GettersTrait;

    public $layout = false;

    public function readline($prompt)
    {
        return readline($prompt);
    }

    public function readpassword($prompt)
    {
        echo $prompt;
        system('stty -echo');
        $password = rtrim(fgets(STDIN), PHP_EOL);
        system('stty echo');
        echo "\n";

        return $password;
    }
}

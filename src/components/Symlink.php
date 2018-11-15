<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

use hidev\base\File as FileObj;
use hidev\helpers\Helper;
use Yii;
use yii\helpers\ArrayHelper;
use hidev\helpers\FileHelper;

/**
 * Symlink component.
 *
 * @author Jomon Johnson <iamjomonjohnson@gmail.com>
 */
class Symlink extends File
{
    /**
     * @var list destimation
     */
    public $dest;

    /**
     * General save: save and modify.
     */
    public function save()
    {
        if (!$this->once || !$this->exists()) {
            FileHelper::symlink($this->dest, $this->_path);
        }
    }

}

<?php

/*
 * Automation tool mixed with code generator for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

class BinariesController extends CommonController
{
    use \hiqdev\yii2\collection\ManagerTrait;

    public $defaultClass = 'hidev\base\BinaryPhp';

    public function actionMake()
    {
        foreach ($this->getItems() as $name => $bin) {
            if (!$bin->detectPath($name)) {
                $exitcode = $bin->install();
                if ($exitcode) {
                    return $exitcode;
                }
            }
        }
    }

    /**
     * Prepares item config.
     */
    public function getItemConfig($name = null, array $config = [])
    {
        return array_merge([
            'name'  => $name,
            'class' => $this->defaultClass,
        ], $config);
    }

    /**
     * Prepares and runs with passthru. Returns exit code.
     * @param string $name binary
     * @param array|string $args
     * @return int exit code
     */
    public function passthruBinary($name, $args = [])
    {
        return $this->get($name)->passthru($args);
    }

    /**
     * Prepares and runs with exec. Returns stdout string.
     * @param string $name binary
     * @param string $args
     * @return array stdout
     */
    public function execBinary($name, $args = '', $returnExitCode = false)
    {
        return $this->get($name)->exec($args, $returnExitCode);
    }
}

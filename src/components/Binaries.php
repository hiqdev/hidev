<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

class Binaries extends \hiqdev\yii2\collection\Manager
{
    public $defaultClass = 'hidev\base\BinaryPhp';

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
     * Prepares and runs with passthru.
     * @param string $name binary
     * @param string $args
     * @return int exit code
     */
    public function passthru($name, $args = [])
    {
        return $this->get($name)->passthru($args);
    }
}

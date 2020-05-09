<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
 */

return [
    'id' => 'hidev-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'binaries' => [
            'class' => \hidev\components\Binaries::class,
        ],
    ],
];

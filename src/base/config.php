<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

return [
    'id'                    => 'hidev',
    'name'                  => 'HiDev',
    'basePath'              => dirname(__DIR__),
    'vendorPath'            => dirname(HIDEV_AUTOLOAD_FILE),
    'runtimePath'           => dirname(substr(__DIR__, 0, 7) === 'phar://' ? $_SERVER['SCRIPT_NAME'] : dirname(__DIR__)) . '/runtime',
    'enableCoreCommands'    => false,
    'controllerNamespace'   => 'hidev\\controllers',
    'defaultRoute'          => 'default',
    'bootstrap'             => ['log'],
    'components'            => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*'request' => [
            'class' => 'hidev\base\Request',
        ],*/
        'binaries' => [
            'class' => 'hidev\components\Binaries',
        ],
        'config' => [
            'class' => 'hidev\components\Config',
            'init' => [
                'class' => 'hidev\controllers\InitController',
            ],
            'vendor' => [
                'class' => 'hidev\controllers\VendorController',
            ],
            'package' => [
                'class' => 'hidev\controllers\PackageController',
            ],
            'vcsignore' => [
                'class' => 'hidev\controllers\VcsignoreController',
            ],
            '.gitignore' => [
                'class' => 'hidev\controllers\GitignoreController',
            ],
            'CHANGELOG.md' => [
                'class' => 'hidev\controllers\ChangelogController',
            ],
        ],
        'view' => [
            'class' => 'hidev\base\View',
            'theme' => [
                'pathMap' => [
                    '@app/views' => ['@hidev/views'],
                ],
            ],
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'extensions' => ['Twig_Extension_StringLoader'],
                ],
            ],
        ],
    ],
];

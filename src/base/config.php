<?php

return [
    'id'                    => 'hidev',
    'name'                  => 'HiDev',
    'basePath'              => dirname(__DIR__),
    'vendorPath'            => dirname(dirname(__DIR__)) . '/vendor',
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
            'vendor' => [
                'class' => 'hidev\controllers\VendorController',
            ],
            'package' => [
                'class' => 'hidev\controllers\PackageController',
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


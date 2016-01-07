<?php

return [
    'id'                    => 'hidev',
    'name'                  => 'HiDev',
    'basePath'              => '@hidev',
    'vendorPath'            => '@vendor',
    'runtimePath'           => dirname(substr(__DIR__, 0, 7) === 'phar://' ? $_SERVER['SCRIPT_NAME'] : dirname(__DIR__)) . '/runtime',
    'enableCoreCommands'    => false,
    'controllerNamespace'   => 'hidev\\controllers',
    'defaultRoute'          => 'default/deps',
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
        'request' => [
            'class' => 'hidev\base\Request',
        ],
        'binaries' => [
            'class' => 'hidev\components\Binaries',
        ],
        'config' => [
            'class'         => 'hidev\components\Config',
            'git'           => 'hidev\goals\GitGoal',
            'init'          => 'hidev\goals\InitGoal',
            'start'         => 'hidev\goals\StartGoal',
            'github'        => 'hidev\goals\GitHubGoal',
            'update'        => 'hidev\goals\UpdateGoal',
            'vendor'        => 'hidev\goals\VendorGoal',
            'commits'       => 'hidev\goals\CommitsGoal',
            'install'       => 'hidev\goals\InstallGoal',
            'package'       => 'hidev\goals\PackageGoal',
            '.gitignore'    => 'hidev\goals\GitignoreGoal',
            'vcsignore'     => 'hidev\goals\VcsignoreGoal',
            'CHANGELOG.md'  => 'hidev\goals\ChangelogGoal',
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


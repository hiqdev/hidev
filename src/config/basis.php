<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

if (!defined('HIDEV_VENDOR_DIR')) {
    define('HIDEV_VENDOR_DIR', dirname(dirname(dirname(dirname(__DIR__)))));
}

return [
    'id'                    => 'hidev',
    'name'                  => 'HiDev',
    'basePath'              => dirname(__DIR__),
    'vendorPath'            => HIDEV_VENDOR_DIR,
    'runtimePath'           => substr(__DIR__, 0, 7) === 'phar://' ? dirname($_SERVER['SCRIPT_NAME']) : dirname(HIDEV_VENDOR_DIR) . '/runtime',
    'controllerNamespace'   => 'hidev\\controllers',
    'defaultRoute'          => 'default',
    'bootstrap'             => ['log'],
    'components'            => [
        'log' => [
            'class' => \yii\log\Dispatcher::class,
            'targets' => [
                'console' => [
                    'class' => \hidev\log\ConsoleTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'view' => [
            'class' => \yii\base\View::class,
            'renderers' => [
                'twig' => [
                    'class' => \yii\twig\ViewRenderer::class,
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'extensions' => ['Twig_Extension_StringLoader'],
                ],
            ],
        ],
        /// operational components
        'vcsignore' => [
            'class' => \hidev\components\Vcsignore::class,
        ],
        'git' => [
            'class' => \hidev\components\Git::class,
        ],
        'github' => [
            'class' => \hidev\components\GitHub::class,
        ],
        'package' => [
            'class' => \hidev\components\Package::class,
        ],
        'vendor' => [
            'class' => \hidev\components\Vendor::class,
        ],
        'codeception' => [
            'class' => \hidev\components\WTF::class,
        ],
    ],
    'controllerMap' => [
        /// internally used actions
        'binaries' => [
            'class' => \hidev\controllers\BinariesController::class,
            'composer' => [
                'class' => \hidev\base\BinaryPhp::class,
                'installer' => 'https://getcomposer.org/installer',
            ],
            'pip' => [
                'class' => \hidev\base\BinaryPython::class,
                'installer' => 'https://bootstrap.pypa.io/get-pip.py',
            ],
        ],
        /// basic actions
        'init' => [
            'class' => 'hidev\controllers\InitController',
        ],
        '--version' => [
            'class' => 'hidev\controllers\OwnVersionController',
        ],
        'update' => [
            'before' => [
                'start/update',
            ],
        ],
        /// standard actions
        'vendor' => [
            'class' => 'hidev\controllers\VendorController',
        ],
        'package' => [
            'class' => 'hidev\controllers\PackageController',
        ],
        'command' => [
            'class' => 'hidev\controllers\CommandController',
        ],
        'template' => [
            'class' => 'hidev\controllers\TemplateController',
        ],
        'directory' => [
            'class' => 'hidev\controllers\DirectoryController',
        ],
        /// git/vcs actions
        'github' => [
            'class' => 'hidev\controllers\GithubController',
        ],
        'vcsignore' => [
            'class' => 'hidev\controllers\VcsignoreController',
        ],
        '.gitignore' => [
            'class' => 'hidev\controllers\GitignoreController',
        ],
    ],
    'container' => [
        'singletons' => [
            \hidev\base\Interpolator::class => [
            ],
        ],
    ],
    'params' => [
    ],
];

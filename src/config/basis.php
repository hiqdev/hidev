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
            'class' => \hidev\components\Log::class,
            'flushInterval' => 1,
            'targets' => [
                'console' => [
                    'class' => \hidev\log\ConsoleTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'request' => [
            'class' => \hidev\components\Request::class,
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
        /// goal components
        'vcs' => [
            'class' => 'Detect VCS',
        ],
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
        'binaries' => [
            'class' => \hidev\components\Binaries::class,
            'composer' => [
                'class' => \hidev\base\BinaryPhp::class,
                'installer' => 'https://getcomposer.org/installer',
            ],
            'pip' => [
                'class' => \hidev\base\BinaryPython::class,
                'installer' => 'https://bootstrap.pypa.io/get-pip.py',
            ],
        ],
    ],
    'controllerMap' => [
        '--version' => [
            'class' => \hidev\controllers\OwnVersionController::class,
        ],
        '.gitignore' => [
            'class' => \hidev\controllers\GitignoreController::class,
        ],
    ],
    'container' => [
        'singletons' => [
            \hidev\base\Interpolator::class => [
            ],
            'Detect VCS' => function () {
                $detectedVCS = 'git';
                return Yii::$app->get($detectedVCS);
            },
        ],
    ],
    'params' => [
    ],
];

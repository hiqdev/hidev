<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

if (!defined('HIDEV_VENDOR_DIR')) {
    define('HIDEV_VENDOR_DIR', dirname(dirname(dirname(dirname(__DIR__)))));
}

$runtimePath = (substr(__DIR__, 0, 7) === 'phar://' ? dirname($_SERVER['SCRIPT_NAME']) : dirname(HIDEV_VENDOR_DIR)) . '/.hidev/runtime';

return [
    'id'                    => 'hidev',
    'name'                  => 'HiDev',
    'basePath'              => dirname(__DIR__),
    'vendorPath'            => HIDEV_VENDOR_DIR,
    'runtimePath'           => $runtimePath,
    'controllerNamespace'   => 'hidev\\console',
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
            'class' => \hidev\components\View::class,
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
        'vcs' => [
            'class' => \hidev\components\AbstractVcs::class,
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
        'version' => [
            'class' => \hidev\components\Version::class,
        ],
        'own.version' => [
            'class' => \hidev\components\Version::class,
            'file'  => dirname(dirname(__DIR__)) . '/version',
        ],
    ],
    'controllerMap' => [
        '--version' => [
            'class' => \hidev\console\VersionController::class,
            'own' => true,
        ],
        '.gitignore' => [
            'class' => \hidev\console\GitignoreController::class,
        ],
        'github' => [
            'class' => \hidev\console\GithubController::class,
        ],
        'dump' => [
            'class' => \hidev\console\DumpController::class,
        ],
    ],
    'container' => [
        'singletons' => [
            \hidev\components\AbstractVcs::class => function () {
                $detectedVCS = 'git'; /// TODO actual detection to be added
                return Yii::$app->get($detectedVCS);
            },
        ],
        'definitions' => [
            'file'      => \hidev\components\File::class,
            'command'   => \hidev\components\Command::class,
            'directory' => \hidev\components\Directory::class,
        ],
    ],
];

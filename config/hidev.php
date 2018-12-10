<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

#$runtimePath = (substr(__DIR__, 0, 7) === 'phar://' ? dirname($_SERVER['SCRIPT_NAME']) : dirname(HIDEV_VENDOR_DIR)) . '/.hidev/runtime';

return array_filter([
    'app' => [
        'id'                    => 'hidev',
        'name'                  => 'HiDev',
        'basePath'              => dirname(__DIR__),
#       'runtimePath'           => $runtimePath,
        'controllerNamespace'   => \hidev\console::class,
        'defaultRoute'          => 'default',
        'controllerMap' => [
            '--version' => [
                '__class' => \hidev\console\VersionController::class,
                'own' => true,
            ],
            '.gitignore' => [
                '__class' => \hidev\console\GitignoreController::class,
            ],
            'git' => [
                '__class' => \hidev\console\GitController::class,
            ],
            'github' => [
                '__class' => \hidev\console\GithubController::class,
            ],
            'dump' => [
                '__class' => \hidev\console\DumpController::class,
            ],
        ],
    ],
    'logger' => [
        'flushInterval' => 1,
        'targets' => [
            'console' => [
                '__class' => \hidev\log\ConsoleTarget::class,
                'levels' => ['error', 'warning', 'info'],
            ],
        ],
    ],
    'request' => [
        '__class' => \hidev\components\Request::class,
    ],
    'cache' => [
        'handler' => [
            '__class' => \yii\cache\FileCache::class,
        ],
    ],
    'view' => [
        '__class' => \hidev\components\View::class,
        'renderers' => [
            'twig' => [
                '__class' => \yii\twig\ViewRenderer::class,
                'cachePath' => '@runtime/Twig/cache',
                'options' => [
                    'auto_reload' => true,
                ],
                'extensions' => ['Twig_Extension_StringLoader'],
            ],
        ],
    ],
    'binaries' => [
        '__class' => \hidev\components\Binaries::class,
        'composer' => [
            '__class' => \hidev\base\BinaryPhp::class,
            'installer' => 'https://getcomposer.org/installer',
        ],
        'pip' => [
            '__class' => \hidev\base\BinaryPython::class,
            'installer' => 'https://bootstrap.pypa.io/get-pip.py',
        ],
    ],
    'vcs' => [
        '__class' => \hidev\components\AbstractVcs::class,
    ],
    'vcsignore' => [
        '__class' => \hidev\components\Vcsignore::class,
    ],
    'git' => [
        '__class' => \hidev\components\Git::class,
    ],
    'github' => [
        '__class' => \hidev\components\GitHub::class,
    ],
    'package' => [
        '__class' => \hidev\components\Package::class,
    ],
    'vendor' => [
        '__class' => \hidev\components\Vendor::class,
    ],
    'version' => [
        '__class' => \hidev\components\Version::class,
    ],
    'own.version' => [
        '__class' => \hidev\components\Version::class,
        'file'  => dirname(__DIR__) . '/version',
    ],
    \hidev\components\AbstractVcs::class => function () {
        $detectedVCS = 'git'; /// TODO actual detection to be added
        return Yii::$app->get($detectedVCS);
    },
    'factory' => [
        '__class' => 'yii\\di\\Factory',
        '__construct()' => [
            'definitions' => [
                'file'      => \hidev\components\File::class,
                'command'   => \hidev\components\Command::class,
                'directory' => \hidev\components\Directory::class,
            ],
        ],
    ],
]);

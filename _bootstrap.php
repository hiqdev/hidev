<?php

foreach ([__DIR__ . '/vendor/autoload.php', __DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php'] as $file) {
    if (file_exists($file)) {
        define('HIDEV_COMPOSER_INSTALL', $file);
        break;
    }
}

if (!defined('HIDEV_COMPOSER_INSTALL')) {
    fwrite(STDERR, 'You need to set up project dependencies with composer');
}

require(HIDEV_COMPOSER_INSTALL);

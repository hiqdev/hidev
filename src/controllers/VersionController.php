<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

/**
 * Version management.
 */
class VersionController extends \hidev\base\Controller
{
    public $own;

    public $defaultAction = 'show';

    /**
     * Show current version.
     * @param string $release
     */
    public function actionShow($release = null)
    {
        $version = $this->getComponent();
        $version->load();
        $version->setRelease($release);
        $dir = dirname($version->getAbspath());
        echo $version->renderFile() . PHP_EOL;
        echo "(run from $dir)\n";
    }

    /**
     * Update version.
     * @param string $release
     */
    public function actionUpdate($release = null)
    {
        $this->getComponent()->update($release);
    }

    public function getComponent()
    {
        return $this->take(($this->own ? 'own.' : '') . 'version');
    }
}

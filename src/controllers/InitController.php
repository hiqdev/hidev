<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Exception;
use hidev\base\File;
use hidev\helpers\Helper;
use Yii;
use yii\base\InvalidParamException;

/**
 * Init controller.
 * Builds .hidev/config.yml by template and params.
 */
class InitController extends \yii\console\Controller
{
    /**
     * @var string package full name like: vendor/package
     */
    public $name;

    /**
     * @var string package type e.g.: package, yii2-extension
     */
    public $type;

    public $title;
    public $package;
    public $license;
    public $headline;
    public $keywords;
    public $namespace;
    public $description;

    public $vendor;
    public $nick;
    public $author;
    public $email;

    public $vendorRequire;

    /**
     * @var bool don't put vendor config
     */
    public $noVendor;
    /**
     * @var bool don't put requires
     */
    public $noRequire;

    /**
     * @var bool don't generate `composer.json` file
     */
    public $noComposer;

    public function options($actionId)
    {
        return array_diff(
            array_keys(get_object_vars($this)),
            explode(',', 'color,help,id,module,layout,action,interactive,defaultAction')
        );
    }

    public function prepareData($name)
    {
        $this->name = $name;
        list($vendor, $package) = explode('/', $name, 2);
        if ($vendor) {
            $this->vendor = $vendor;
            $vendorPlugin = "$vendor/hidev-$vendor";
            try {
                $exists = @file_get_contents("https://packagist.org/packages/$vendorPlugin.json");
            } catch (Exception $e) {
                $exists = false;
            }
            if ($exists) {
                $this->vendorRequire = $vendorPlugin;
                $this->noVendor = true;
            }
        }
        if ($package) {
            $this->package = $package;
        }
        if (!$this->package || !$this->vendor) {
            throw new InvalidParamException('Wrong vendor/package given: ' . $name);
        }
    }

    /**
     * Creates initial configuration for hidev: `hidev.yml` and `composer.json`.
     * @param string $name package full name like: vendor/package
     */
    public function actionIndex($name = null)
    {
        $this->prepareData($name);
        if (!$this->noComposer) {
            $this->writeComposer();
        }

        return $this->writeConfig();
    }

    public function actionComposer()
    {
        return $this->writeComposer();
    }

    public function writeConfig($path = 'hidev.yml')
    {
        $file = new File(['path' => $path]);
        $file->save(array_filter([
            'package' => array_filter([
                'type'          => $this->getType(),
                'name'          => $this->package,
                'title'         => $this->getTitle(),
                'license'       => $this->license,
                'headline'      => $this->headline,
                'keywords'      => $this->getKeywords(),
                'namespace'     => $this->namespace,
                'description'   => $this->description,
            ]),
            'vendor' => $this->noVendor ? null : array_filter([
                'name'      => $this->vendor,
                'authors'   => array_filter([
                    $this->getNick() => [
                        'name'  => $this->getAuthor(),
                        'email' => $this->getEmail(),
                    ],
                ]),
            ]),
        ]));
    }

    public function writeComposer($path = 'composer.json')
    {
        $file = new File(['path' => $path]);
        $file->save(array_filter([
            'name'        => $this->name,
            'type'        => $this->getType(),
            'description' => $this->getTitle(),
            'keywords'    => preg_split('/\s*,\s*/', $this->getKeywords()),
            'require-dev' => $this->getPlugins(),
            'license'     => $this->license,
        ]));
    }

    public function getType()
    {
        return $this->type ?: 'project';
    }

    public function getTitle()
    {
        return $this->title ?: Helper::titleize($this->package);
    }

    public function getKeywords()
    {
        return $this->keywords ?: implode(', ', explode('-', $this->package));
    }

    /// TODO think of better getting nick
    public function getNick()
    {
        return $this->nick ?: preg_replace('/[^a-zA-Z_0-9]+/', '', `id -un`);
    }

    public function getAuthor()
    {
        return $this->author ?: Yii::$app->get('vcs')->getUserName();
    }

    public function getEmail()
    {
        return $this->email ?: Yii::$app->get('vcs')->getUserEmail();
    }

    /**
     * Returns list of plugins in composer requirements format: name => version.
     * @return array
     */
    public function getPlugins()
    {
        if ($this->noRequire) {
            return [];
        }
        $res = [
            'hiqdev/hidev-php' => '<2.0 || dev-master',
        ];
        if ($this->vendorRequire) {
            $res[$this->vendorRequire] = '<2.0 || dev-master';
        }

        return $res;
    }
}

<?php

/*
 * HiDev
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hiqdev\hidev\goals;

use Yii;
use yii\base\InvalidParamException;
use hiqdev\hidev\helpers\Helper;

/**
 * Default Goal. 'default' is reserved that's why Base
 */
class Base extends \hiqdev\collection\Manager implements \hiqdev\collection\ItemWithNameInterface
{

    protected $_itemClass = 'hiqdev\collection\Manager';

    public $goal;

    public $done = false;

    public function getName()
    {
        return (string)$this->rawItem('name');
    }

    public function setDeps($deps)
    {
        $res = $this->getDeps();
        foreach (Helper::ksplit($deps) as $d => $e) {
            $res[$d] = $e;
        }
        $this->setItem('deps', $res);
    }

    public function getDeps()
    {
        return Helper::ksplit($this->rawItem('deps'));
    }

    public function runDeps()
    {
        foreach ($this->getDeps() as $name => $enabled) {
            if (!$enabled) {
                continue;
            }
            $goal = $this->getConfig()->get($name);
            if ($goal instanceof self && !$goal->done) {
                $goal->run();
            }
        }
    }

    public function run()
    {
        if ($this->done) {
            Yii::trace("Already done: $this->name");
            return;
        }
        Yii::trace("Started: $this->name");
        $this->runDeps();
        $this->make();
        $this->done = true;
    }

    public function make()
    {
        Yii::trace("Doing nothing for '$this->name'");
        /// throw new InvalidParamException("Don't know how to make '$this->name'");
    }

    public function getConfig()
    {
        return Yii::$app->get('config');
    }

    public function getPackage()
    {
        return $this->getConfig()->getItem('package');
    }

    public function getVendor()
    {
        return $this->getConfig()->getItem('vendor');
    }

}

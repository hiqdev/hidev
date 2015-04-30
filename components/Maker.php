<?php

/*
 * Highy Integrated Development.
 *
 * @link      https://hiqdev.com/hidev
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev 
 */

namespace hiqdev\hidev\components;

use Yii;
use yii\helpers\Inflector;
use yii\base\InvalidParamException;

/**
 * The Maker. Makes the Goals.
 */
class Maker extends \yii\base\Component
{

    /**
     * @var array default config
     */
    protected static $_defaults = [
        'all'       => [],
    ];

    public function make($goal)
    {
        Yii::trace("Goal: $goal");
        d($this->get($goal));
    }

    public function getConfig()
    {
        return Yii::$app->config;
    }

    public function get($goal)
    {
        return $this->config->get($goal);
    }
}

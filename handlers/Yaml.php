<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\handlers;

use Yii;
use Symfony\Component\Yaml\Yaml as YamlComponent;

/**
 * Handler for YAML files.
 */
class Yaml extends Type
{

    /**
     * @inheritdoc
     */
    public function renderType($data)
    {
        return YamlComponent::dump($data);
    }

    /**
     * @inheritdoc
     */
    public function parse($yaml)
    {
        return YamlComponent::parse($yaml);
    }
}

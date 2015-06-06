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

use Symfony\Component\Yaml\Yaml;

/**
 * Handler for YAML files.
 */
class YamlHandler extends TypeHandler
{
    /**
     * @inheritdoc
     */
    public function renderType($data)
    {
        return Yaml::dump($data);
    }

    /**
     * @inheritdoc
     */
    public function parse($yaml)
    {
        return Yaml::parse($yaml);
    }
}

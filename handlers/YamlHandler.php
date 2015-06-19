<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
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

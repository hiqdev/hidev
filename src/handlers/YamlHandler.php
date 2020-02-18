<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\handlers;

use hidev\base\Interpolator;
use Symfony\Component\Yaml\Yaml;
use yii\helpers\ArrayHelper;

/**
 * Handler for YAML files.
 */
class YamlHandler extends TypeHandler
{
    protected $interpolator;

    public function __construct(Interpolator $interpolator, $options = [])
    {
        parent::__construct($options);
        $this->interpolator = $interpolator;
    }

    /**
     * {@inheritdoc}
     */
    public function renderType($data)
    {
        /// XXX TODO fix getItems crutch
        return Yaml::dump(ArrayHelper::toArray(method_exists($data, 'getItems') ? $data->getItems() : $data), 5);
    }

    /**
     * {@inheritdoc}
     */
    public function parse($yaml)
    {
        $data = (array) Yaml::parse($yaml ?? '');
        $this->interpolator->interpolate($data);

        return $data;
    }
}

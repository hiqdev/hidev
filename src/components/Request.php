<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

/**
 * The Request.
 * Redefined for aliases.
 */
class Request extends \yii\console\Request
{
    protected $_options = [];

    public function getOptions()
    {
        return $this->_options;
    }

    public function resolve()
    {
        $rawParams = $this->getParams();
        foreach ($rawParams as $param) {
            if (strncmp($param, '-', 1) === 0) {
                $this->_options[] = array_shift($rawParams);
            } else {
                break;
            }
        }
        $this->setParams($rawParams);

        return parent::resolve();
    }
}

<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\base;

use hidev\controllers\DefaultController;
use Yii;

/**
 * The Request.
 * Redefined for aliases.
 */
class Request extends \yii\console\Request
{
    /**
     * @var name of script called, like $0 in sh/perl
     */
    protected $_self;

    protected $_args;

    /**
     * Returns the command line arguments.
     *
     * @return array the command line arguments. It does not include the entry script name.
     */
    public function getParams()
    {
        if (!isset($this->_args)) {
            if (isset($_SERVER['argv'])) {
                $args        = $_SERVER['argv'];
                $this->_self = array_shift($args);
                $command     = $args[0];
                $alias       = Yii::$app->config->aliases->get($command);
                if ($alias) {
                    array_shift($args);
                    $args = array_merge($alias, $args);
                }
/*
                $action = $args[0];
                if (Yii::$app->config->hasItem($action)) {
                    array_shift($args);
                    array_unshift($args, 'default/run', $action);
                } elseif (DefaultController::hasAction($action)) {
                    array_shift($args);
                    array_unshift($args, "default/$action");
                }
*/
                $this->_args = $args;
            } else {
                $this->_args = [];
            }
            $this->setParams($this->_args);
        }

        return $this->_args;
    }

    public function setParams($params)
    {
        parent::setParams($params);
        $this->_args = $params;
    }
}

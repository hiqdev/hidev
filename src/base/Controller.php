<?php
/**
 * Automation tool mixed with code generator for easier continuous development.
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\base;

use hidev\console\CommonBehavior;

/**
 * Basic controller.
 */
abstract class Controller extends \yii\console\Controller
{
    use GettersTrait;

    public $layout = false;

    protected $_before = [];
    protected $_after  = [];

    public function behaviors()
    {
        return [
            CommonBehavior::class,
        ];
    }

    public function setBefore($requests)
    {
        $this->_before = array_merge($this->getBefore(), $this->normalizeTasks($requests));
    }

    public function getBefore()
    {
        return $this->_before;
    }

    public function setAfter($requests)
    {
        $this->_after = array_merge($this->getAfter(), $this->normalizeTasks($requests));
    }

    public function getAfter()
    {
        return $this->_after;
    }

    public function readline($prompt)
    {
        return readline($prompt);
    }

    public function readpassword($prompt)
    {
        echo $prompt;
        system('stty -echo');
        $password = rtrim(fgets(STDIN), PHP_EOL);
        system('stty echo');
        echo "\n";

        return $password;
    }

    /**
     * Runs list of actions.
     * @param null|string|array $actions
     * @return int|Response exit code
     */
    public function runActions($actions)
    {
        foreach ($this->normalizeTasks($actions) as $action => $enabled) {
            if ($enabled) {
                $res = $this->runAction($action);
                if (!static::isResponseOk($res)) {
                    return $res;
                }
            }
        }

        return 0;
    }

    /**
     * Is response Ok.
     * @param Response|int $response
     * @return bool
     */
    public static function isResponseOk($response)
    {
        return !(is_object($response) ? $response->exitStatus : $response);
    }
}

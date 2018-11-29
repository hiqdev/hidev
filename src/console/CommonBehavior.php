<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hidev\console;

use hidev\base\Controller;
use hidev\helpers\Helper;
use yii\base\ActionEvent;
use yii\console\Request;

/**
 * Common controller behavior.
 */
class CommonBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            ActionEvent::BEFORE => 'onBeforeAction',
            ActionEvent::AFTER  => 'onAfterAction',
        ];
    }

    protected $beforeResult;

    public function onBeforeAction($event)
    {
        $result = $this->runRequests($event->sender->before);
        if (!Helper::isResponseOk($result)) {
            $this->beforeResult = $result;
            $event->isValid = false;
        }
    }

    public function getBeforeResult()
    {
        return $this->beforeResult;
    }

    public function onAfterAction($event)
    {
        $this->runRequests($event->sender->after);
    }

    public function runRequests($requests)
    {
        foreach ($this->normalizeTasks($requests) as $request => $enabled) {
            if ($enabled) {
                $response = $this->runRequest($request);
                if (!Helper::isResponseOk($response)) {
                    return $response;
                }
            }
        }
    }

    public function normalizeTasks($tasks)
    {
        if (!$tasks) {
            return [];
        } elseif (!is_array($tasks)) {
            $tasks = [(string) $tasks => 1];
        }
        $res = [];
        foreach ($tasks as $dep => $enabled) {
            $res[(string) (is_int($dep) ? $enabled : $dep)] = (bool) (is_int($dep) ? 1 : $enabled);
        }

        return $res;
    }

    /**
     * Run request.
     * @param string|array $query
     * @return Response
     */
    public function runRequest($query)
    {
        $request = $this->app->createObject([
            'class'  => Request::class,
            'params' => is_array($query) ? $query : array_filter(explode(' ', $query)),
        ]);

        return $this->app->handleRequest($request);
    }
}

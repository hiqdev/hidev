<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\controllers;

use Yii;

/**
 * Common controller behavior.
 */
class CommonBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            CommonController::EVENT_BEFORE_ACTION => 'onBeforeAction',
            CommonController::EVENT_AFTER_ACTION  => 'onAfterAction',
        ];
    }

    public function onBeforeAction($event)
    {
        $this->runRequests($event->sender->before);
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
                if ($this->isNotOk($response)) {
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
     * Is response NOT Ok.
     * @param Response|int $response
     * @return bool
     */
    public function isNotOk($response)
    {
        return is_object($response) ? $response->exitStatus : $response;
    }

    /**
     * Run request.
     * @param string|array $query
     * @return Response
     */
    public function runRequest($query)
    {
        $request = Yii::createObject([
            'class'  => \yii\console\Request::class,
            'params' => is_array($query) ? $query : array_filter(explode(' ', $query)),
        ]);

        return Yii::$app->handleRequest($request);
    }
}

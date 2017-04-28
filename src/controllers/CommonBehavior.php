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
        foreach ((array) $requests as $request) {
            $this->runRequest($request);
        }
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

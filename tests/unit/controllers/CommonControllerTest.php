<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\tests\unit\controllers;

use hidev\controllers\CommonController;

class CommonControllerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CommonController
     */
    protected $object;

    protected $before = 'asd';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CommonController('test', null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testSetBefore()
    {
        $this->object->setBefore($this->before);
        $this->assertSame([$this->before => true], $this->object->getBefore());
    }
}

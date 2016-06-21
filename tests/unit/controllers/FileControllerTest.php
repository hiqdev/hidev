<?php

/*
 * Build tool mixed with code generator for easier automation and continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hidev\tests\unit\controllers;

use hidev\controllers\FileController;

/**
 * Tests from FileController.
 */
class FileControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileController
     */
    protected $object;

    protected $template = 'asd';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new FileController('test', null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testSetTemplate()
    {
        $this->object->setTemplate($this->template);
        $this->assertSame($this->template, $this->object->getTemplate());
    }
}

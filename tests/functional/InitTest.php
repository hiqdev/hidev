<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hidev\tests\functional;

class InitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FunctionalTester
     */
    protected $tester;

    protected function setUp()
    {
        $this->tester = new Tester($this);
    }

    protected function tearDown()
    {
        $this->tester = null;
    }

    /**
     * Test minimal: init the-vendor/my-new-package.
     */
    public function testMinimal()
    {
        $this->tester->hidev(['init', 'the-vendor/my-new-package', '--nick=sol', '--author=Author Name', '--email=author@email.com']);
        $this->tester->assertFiles(__DIR__ . '/minimal', ['.hidev/config.yml', 'composer.json']);
    }

    /**
     * Test plugins: init hiqdev/my-new-package.
     */
    public function testPlugins()
    {
        $this->tester->hidev(['init', 'hiqdev/my-new-package', '--nick=sol', '--author=Author Name', '--email=author@email.com']);
        $this->tester->assertFiles(__DIR__ . '/plugins', ['.hidev/config.yml', 'composer.json']);
    }

    /**
     * Test options: init the-vendor/new-package.
     */
    public function testOptions()
    {
        $this->tester->hidev([
            'init', 'the-vendor/new-package', '--nick=sol', '--namespace=thevendor\\other\\newpackage', '--headline=New Package',
            '--title=The new library package', '--type=library', '--keywords=new,package,of,the,vendor', '--license=MIT',
            '--description=The project longer description', '--year=2014', '--novendor', '--norequire', '--nocomposer',
        ]);
        $this->tester->assertFiles(__DIR__ . '/options', ['.hidev/config.yml']);
    }
}

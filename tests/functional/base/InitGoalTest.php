<?php

namespace base;

use Yii;

class InitGoalTest extends \Codeception\TestCase\Test
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester = new FunctionalTester($this);
    }

    protected function _after()
    {
        $this->tester = null;
    }

    /**
     * Test minimal: init the-vendor/new-package
     */
    public function testMinimal()
    {
        $this->tester->hidev('init the-vendor/new-package');
        $this->tester->assertFile('.hidev/config.yml','
package:
    name:           new-package
    title:          New Package
    type:           package
    keywords:       new, package

require:
    the-vendor/hidev-config:        "*"
    hiqdev/hidev-config-php:    "*"
        ');
    }

    /**
     * Test options: init the-vendor/new-package 
     */
    public function testOptions()
    {
        $this->tester->hidev('init the-vendor/new-package "--namespace=thevendor\\other\\newpackage" --label=NewPackage "--title=The New Package" --type=yii2-extension --keywords=new,package,of,the,vendor');
        $this->tester->assertFile('.hidev/config.yml','
package:
    name:           new-package
    namespace:      thevendor\other\newpackage
    label:          NewPackage
    title:          The New Package
    type:           yii2-extension
    keywords:       new,package,of,the,vendor

require:
    the-vendor/hidev-config:        "*"
    hiqdev/hidev-config-php:    "*"
        ');
    }
}

class FunctionalTester
{
    public $test;

    public $dir;

    public function path($file, $dir = null)
    {
        return ($dir ?: $this->dir) . DIRECTORY_SEPARATOR . $file;
    }

    public function __construct($test)
    {
        static $no = 0;
        $no++;
        $this->test = $test;
        $this->now = date("c");
        $this->dir = $this->path($this->now . '-' . $no, Yii::getAlias('@hidev/tests/_output'));
        mkdir($this->dir);
        chdir($this->dir);
    }

    public function __destruct()
    {
        exec('rm -rf ' . $this->dir);
    }

    public function hidev($params)
    {
        $command = Yii::getAlias('@hidev/bin/hidev') . ' ' . $params;
        exec($command);
    }

    public function assertFile($file, $content)
    {
        $data = file_get_contents($this->path($file));
        $this->test->assertEquals(trim($data), trim($content));
    }
}

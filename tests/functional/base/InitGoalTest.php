<?php

namespace base;

use hidev\tests\functional\Tester;

class InitGoalTest extends \Codeception\TestCase\Test
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester = new Tester($this);
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
    type:           project
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

<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

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
     * Test minimal: init the-vendor/new-package.
     */
    public function testMinimal()
    {
        $this->tester->hidev('init the-vendor/new-package "--author=Author Name" --email=author@email.com');
        $this->tester->assertFile('.hidev/config.yml', '
package:
    name:           new-package
    type:           project
    keywords:       new, package

vendor:
    name:           the-vendor
    authors:
        \'Author Name\':
            email:      author@email.com

require:
    hiqdev/hidev-config-php:    "*"
        ');
    }

    /**
     * Test options: init the-vendor/new-package.
     */
    public function testOptions()
    {
        $this->tester->hidev('init the-vendor/new-package "--namespace=thevendor\\other\\newpackage" --label=NewPackage "--title=The New Package" --type=yii2-extension --keywords=new,package,of,the,vendor "--description=The project longer description" --year=2014 --novendor --norequire');
        $this->tester->assertFile('.hidev/config.yml', '
package:
    name:           new-package
    namespace:      thevendor\other\newpackage
    label:          NewPackage
    title:          The New Package
    type:           yii2-extension
    keywords:       new,package,of,the,vendor
    description:    The project longer description
    year:           2014
        ');
    }
}

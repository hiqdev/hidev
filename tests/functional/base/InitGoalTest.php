<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace base;

use hidev\tests\functional\Tester;

class InitGoalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \FunctionalTester
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
        $this->tester->hidev('init the-vendor/my-new-package --nick=sol "--author=Author Name" --email=author@email.com');
        $this->tester->assertFile('.hidev/config.yml', '
package:
    type:           project
    name:           my-new-package
    title:          My New Package
    keywords:       my, new, package

vendor:
    name:           the-vendor
    authors:
        sol:
            name:       Author Name
            email:      author@email.com

require:
    hiqdev/hidev-php:       "*"
        ');
    }

    /**
     * Test smart require: init hiqdev/my-new-package.
     */
    public function testSmartRequire()
    {
        $this->tester->hidev('init hiqdev/my-new-package --nick=sol "--author=Author Name" --email=author@email.com');
        $this->tester->assertFile('.hidev/config.yml', '
package:
    type:           project
    name:           my-new-package
    title:          My New Package
    keywords:       my, new, package

require:
    hiqdev/hidev-php:       "*"
    hiqdev/hidev-vendor:    "*"
        ');
    }

    /**
     * Test options: init the-vendor/new-package.
     */
    public function testOptions()
    {
        $this->tester->hidev('init the-vendor/new-package --nick=sol "--namespace=thevendor\\other\\newpackage" "--headline=New Package" "--title=The new library package" --type=library --keywords=new,package,of,the,vendor --license=MIT "--description=The project longer description" --year=2014 --novendor --norequire');
        $this->tester->assertFile('.hidev/config.yml', '
package:
    type:           library
    name:           new-package
    namespace:      thevendor\other\newpackage
    headline:       New Package
    title:          The new library package
    keywords:       new,package,of,the,vendor
    license:        MIT
    year:           2014
    description:    The project longer description
        ');
    }
}

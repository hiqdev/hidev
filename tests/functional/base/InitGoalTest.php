<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
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
    hiqdev/hidev-php:   "*"
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

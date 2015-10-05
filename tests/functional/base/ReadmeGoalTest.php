<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace base;

use hidev\tests\functional\Tester;

class ReadmeGoalTest extends \Codeception\TestCase\Test
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
     * Test minimal.
     */
    public function testMinimal()
    {
        $this->tester->hidev('init the-vendor/new-test-package --norequire --year=2015 "--description=The project longer decription"');
        $this->tester->hidev('README.md');
        $this->tester->assertFileHas('README.md', [
            "New Test Package\n----------------",
            'The project longer decription',
            '## Installation',
            'The preferred way to install this project is through [composer](http://getcomposer.org/download/).',
            'php composer.phar create-project "the-vendor/new-test-package:*" directory2install',
            '## Licence',
            'This project is released under the terms of the No license',
            'Read more [here](http://choosealicense.com/licenses/no-license).',
            'Copyright © 2015, The Vendor',
        ]);
    }

    /**
     * Test options.
     */
    public function testOptions()
    {
    }
}

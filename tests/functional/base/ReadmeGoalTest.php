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

class ReadmeGoalTest extends \PHPUnit_Framework_TestCase
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
     * Test minimal.
     */
    public function testMinimal()
    {
        $this->tester->hidev('init the-vendor/new-test-package --norequire --year=2014');
        $this->tester->hidev('README.md');
        $this->tester->assertFileHas('README.md', [
            "New Test Package\n================",
            "\n\n## License\n\n",
            'This project is released under the terms of the No license',
            'Read more [here](http://choosealicense.com/licenses/no-license).',
            'Copyright © 2014-' . date('Y') . ', The Vendor',
        ]);
    }

    /**
     * Test options.
     */
    public function testMore()
    {
        $this->tester->hidev('init the-vendor/new-test-package --norequire --headline=Package --license=MIT --year=2014 "--description=The project longer decription"');
        $this->tester->hidev('README.md');
        $this->tester->assertFileHas('README.md', [
            "Package\n=======",
            '**New Test Package**',
            'The project longer decription',
            '## License',
            'This project is released under the terms of the MIT [license](LICENSE)',
            'Read more [here](http://choosealicense.com/licenses/mit).',
        ]);
    }

    /**
     * Test docs/readme.
     */
    public function testDocs()
    {
        $this->tester->hidev('init the-vendor/new-test-package --norequire --year=2015');
        $this->tester->writeFile('docs/readme/Usage.md', "Usage instructions.\nIn multiple lines.");
        $this->tester->hidev('README.md');
        $this->tester->assertFileHas('README.md', [
            "\n\n## Usage\n\nUsage instructions.\nIn multiple lines.\n\n",
        ]);
    }
}

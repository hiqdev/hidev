<?php

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
     * Test minimal
     */
    public function testMinimal()
    {
        $this->tester->hidev('init the-vendor/new-test-package --norequire');
        $this->tester->appendFile('.hidev/config.yml','

vendor:
    name:    the-vendor
        ');
        $this->tester->hidev('README.md');
        die();
    }

    /**
     * Test options: init the-vendor/new-package
     */
    public function testMore()
    {
    }
}

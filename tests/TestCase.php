<?php

namespace Tequilarapido\ResultCache\Test;

use Tequilarapido\ResultCache\ResultCacheServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /** @var TestHelper */
    protected $helper;

    public function setUp()
    {
        parent::setUp();

        $this->helper = new TestHelper($this->app);
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->helper = null;
    }
}
<?php


namespace Tequilarapido\ResultCache\Test;


use Tequilarapido\ResultCache\ResultCache;

class ResultCacheTest extends TestCase
{

    /** @test */
    public function it_returns_key()
    {
        $this->assertEquals((new SomeCache)->key(), 'some.key');
    }

    /** @test */
    public function it_returns_concrete_key(){

        $this->assertEquals($this->helper->invokeMethod(new SomeCache, 'getCacheKey'), 'some.key');
    }

    /** @test */
    public function it_returns_data()
    {
        $this->assertEquals((new SomeCache)->data(), 'some.data');
    }

}


class SomeCache extends ResultCache
{

    public function key()
    {
        return 'some.key';
    }

    public function data()
    {
        return 'some.data';
    }
}

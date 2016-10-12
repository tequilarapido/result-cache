<?php

namespace Tequilarapido\ResultCache\Test;

use Illuminate\Contracts\Cache\Repository;
use Tequilarapido\ResultCache\ResultCache;

use Mockery;

class ResultCacheTest extends TestCase
{

    /** @test */
    public function it_returns_key()
    {
        $this->assertEquals((new SomeCache)->key(), 'some.key');
    }

    /** @test */
    public function it_returns_concrete_key()
    {

        $this->assertEquals($this->helper->invokeMethod(new SomeCache, 'getCacheKey'), 'some.key');
    }

    /** @test */
    public function it_returns_data()
    {
        $this->assertEquals((new SomeCache)->data(), 'some.data');
    }

    /** @test */
    public function it_returns_and_sets_cache_correctly()
    {
        $this->assertEquals((new SomeCache)->get(), 'some.data');
        $this->assertEquals(app('cache')->get('some.key'), 'some.data');
    }

    /** @test */
    public function it_returns_from_cache_if_available()
    {
        // This is supposed to cache 'some.data'
        (new SomeCache)->get();

        // Alter cache to make sure we are getting the cached value
        app('cache')->put('some.key', 'altered.data', 10);
        $this->assertEquals((new SomeCache)->get(), 'altered.data');

        // Expect expected value after cache clear
        app('cache')->forget('some.key');
        $this->assertEquals((new SomeCache)->get(), 'some.data');
    }

    /** @test */
    public function it_can_forget_its_cache()
    {
        (new SomeCache)->get();

        (new SomeCache)->forget();

        $this->assertFalse(app('cache')->has('some.key'));
    }

    /** @test */
    public function is_can_set_cache_repo()
    {
        $sc = new SomeCache;
        $sc->setCache($repo = Mockery::mock(Repository::class));
        $this->assertEquals($repo, $sc->getCache());
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

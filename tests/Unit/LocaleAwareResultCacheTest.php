<?php

namespace Tequilarapido\ResultCache\Test;

use Tequilarapido\ResultCache\LocaleAwareResultCache;

class LocaleAwareResultCacheTest extends TestCase
{
    /** @test */
    public function it_returns_supported_locales()
    {
        $this->assertEquals((new SomeLocalAwareCache())->supportedLocales(), ['en', 'fr']);
    }

    /** @test */
    public function it_returns_key()
    {
        $this->assertEquals((new SomeLocalAwareCache())->key(), 'some.key');
    }

    /** @test */
    public function it_returns_concrete_key()
    {
        $sc = new SomeLocalAwareCache();
        $this->assertEquals($this->helper->invokeMethod($sc, 'getCacheKey'), 'some.key::fr');
    }

     /** @test */
     public function it_returns_localized_key()
     {
         $sc = new SomeLocalAwareCache();
         $this->assertEquals($this->helper->invokeMethod($sc, 'localizedKey', ['en']), 'some.key::en');
     }

    /** @test */
    public function it_returns_data()
    {
        $this->assertEquals((new SomeLocalAwareCache())->data(), 'fr.some.data');
    }

    /** @test */
    public function it_returns_and_sets_cache_correctly()
    {
        $this->assertEquals((new SomeLocalAwareCache())->get(), 'fr.some.data');
        $this->assertEquals(app('cache')->get('some.key::fr'), 'fr.some.data');
    }

    /** @test */
    public function it_returns_from_cache_if_available()
    {
        // This is supposed to cache 'some.data'
        (new SomeLocalAwareCache())->get();

        // Alter cache to make sure we are getting the cached value
        app('cache')->put('some.key::fr', 'altered.data', 10);
        $this->assertEquals((new SomeLocalAwareCache())->get(), 'altered.data');

        // Expect expected value after cache clear
        app('cache')->forget('some.key::fr');
        $this->assertEquals((new SomeLocalAwareCache())->get(), 'fr.some.data');
    }

    /** @test */
    public function it_stores_different_caches_for_each_locale_depending_on_app_locale()
    {
        $sc = (new SomeLocalAwareCache())->setLocale(null);

        app()->setLocale('fr');
        $this->assertEquals($sc->get(), 'fr.some.data');
        $this->assertEquals(app('cache')->get('some.key::fr'), 'fr.some.data');

        app()->setLocale('en');
        $this->assertEquals($sc->get(), 'en.some.data');
        $this->assertEquals(app('cache')->get('some.key::en'), 'en.some.data');
    }
}

class SomeLocalAwareCache extends LocaleAwareResultCache
{
    protected $locale = 'fr';

    public function supportedLocales()
    {
        return ['en', 'fr'];
    }

    public function key()
    {
        return 'some.key';
    }

    public function data()
    {
        return ($this->locale ?: app()->getLocale()).'.some.data';
    }
}

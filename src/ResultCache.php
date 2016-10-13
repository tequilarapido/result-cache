<?php

namespace Tequilarapido\ResultCache;

use Illuminate\Contracts\Cache\Repository as CacheRepository;

abstract class ResultCache
{
    /** @var int */
    protected $minutes = 1440;

    /** @var CacheRepository */
    protected $cache;

    /**
     * Return / defines a unique cache key across the application.
     *
     * @return string
     */
    abstract public function key();

    /**
     * This methods must is responsible for returning the data
     * that will be saved in cache.
     *
     * @return mixed
     */
    abstract public function data();

    /**
     * Return concrete used cache key.
     *
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->key();
    }

    /**
     * Return object from the cache.
     *
     * @return mixed
     */
    public function get()
    {
        if ($this->getCache()->has($key = $this->getCacheKey())) {
            return $this->getCache()->get($key);
        }

        $this->getCache()->put($key, $data = $this->data(), $this->minutes);

        return $data;
    }

    /**
     * Removes cache.
     *
     * @return void
     */
    public function forget()
    {
        $this->getCache()->forget($this->getCacheKey());
    }

    /**
     * Set cache repository.
     *
     * @param CacheRepository $cache
     *
     * @return $this
     */
    public function setCache(CacheRepository $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Return cache implementation.
     *
     * @return CacheRepository
     */
    public function getCache()
    {
        return $this->cache ?: app(CacheRepository::class);
    }
}

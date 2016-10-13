<?php

namespace Tequilarapido\ResultCache;

abstract class LocaleAwareResultCache extends ResultCache
{
    /**
     * Locale to be used.
     * If not set, application locale will be used.
     *
     * @var string
     */
    protected $locale;

    /**
     * Return an array of supported application locales.
     *
     * @return array
     */
    abstract public function supportedLocales();

    /**
     * Sets locale.
     *
     * @param $locale
     *
     * @return LocaleAwareResultCache
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Return concrete used cache key.
     *
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->localizedKey($this->locale);
    }

    /**
     * Return cache key suffixed with locale.
     *
     * @param null|string $locale
     *
     * @return string
     */
    protected function localizedKey($locale = null)
    {
        return $this->key().'::'.($locale ?: app()->getLocale());
    }

    /**
     * Removes cache for all locales.
     */
    public function forget()
    {
        foreach ($this->supportedLocales() as $locale) {
            $this->getCache()->forget($this->localizedKey($locale));
        }
    }
}

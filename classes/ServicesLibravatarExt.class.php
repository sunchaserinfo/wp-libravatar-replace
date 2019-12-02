<?php

/**
 * Class ServicesLibravatarExt
 *
 * @author Christian Archer <chrstnarchr@aol.com>
 * @copyright © 2013, Christian Archer
 * @license ISC
 */
class ServicesLibravatarExt extends Services_Libravatar
{
    /**
     * vanilla Services_Libravatar does not approve blank default urls
     * however they work on md5 hashes so allow them for the plugin
     *
     * @param string $url
     * @return string
     */
    protected function processDefault($url)
    {
        if ($url === 'blank') {
            return 'blank';
        }

        try {
            return parent::processDefault($url);
        } catch (InvalidArgumentException $e) {
            // do not fail if the default is incorrect, just ignore it
            return null;
        }
    }

    protected function srvGet($domain, $https = false)
    {
        $cacheKey = 'srv:' . $domain . ':' . ($https ? '1' : '0');
        $cacheGroup = 'libravatar-replace';

        $srv = wp_cache_get($cacheKey, $cacheGroup, false, $found);

        if (!$found) {
            $srv = parent::srvGet($domain, $https);
            wp_cache_set($cacheKey, $srv, $cacheGroup, 43200 + rand(0, 21600)); // cache for 12-18 hours
        }

        return $srv;
    }
}

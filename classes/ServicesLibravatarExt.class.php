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

        return parent::processDefault($url);
    }
}

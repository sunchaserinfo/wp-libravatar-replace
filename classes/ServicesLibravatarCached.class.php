<?php

/**
 * Class ServicesLibravatarCached
 *
 * @author Christian Archer <chrstnarchr@aol.com>
 * @copyright © 2013, Christian Archer
 * @license ISC
 */
class ServicesLibravatarCached extends ServicesLibravatarExt
{
    private $cache_time = 259200; // 60*60*24*3 seconds = 3 days
    private $plugin_file; // for some nice wp plugin functions

    const DEFAULT_SIZE = 80; // gravatar and libravatar const

    /**
     * Plugin file is required to find the cache directory
     *
     * @param $plugin_file
     */
    public function __construct($plugin_file)
    {
        $this->plugin_file = $plugin_file;
    }

    /**
     * Download image instead of showing it, then show from local cache
     *
     * @param string $identifier
     * @param array $options
     * @return string
     */
    public function getUrl($identifier, $options = array())
    {
        $identifier = $this->normalizeIdentifier($identifier);

        $hash = $this->identifierHash($identifier, 'sha256'); // always use sha256 for cache

        $size = $this->size;
        if (isset($options['size'])) {
            $size = $this->processSize($options['size']);
        }

        if ($size === null) {
            $size = self::DEFAULT_SIZE;
        }

        $file_name = 'cache/' . $hash . '-' . $size;

        $file_path = dirname($this->plugin_file) . '/' . $file_name;

        if (is_file($file_path) === false
            || filemtime($file_path) < time() - $this->cache_time
        ) {
            // update cache
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $options['https'] = false; // no need for s2s connections

            $url = parent::getUrl($identifier, $options);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

            $avatar = curl_exec($curl);

            $mime = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

            if (preg_match('~^image(?:/.*)?~', $mime) > 0) {
                file_put_contents($file_path, $avatar); // we have an image
            } else { // we've been tricked!!!
                file_put_contents($file_path, base64_decode('R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==')); // 1x1 transparent gif
            }

            curl_close($curl);
        }

        $file_url = plugins_url($file_name, $this->plugin_file);

        return $file_url;
    }
}

<?php

/**
 * Class LibravatarReplace
 *
 * everything for the plugin to work
 *
 * @author Gabriel Hautclocq
 * @author Christian Archer <chrstnarchr@aol.com>
 * @copyright © 2011, Gabriel Hautclocq
 * @copyright © 2013, Christian Archer
 * @license ISC
 */
class LibravatarReplace
{
	private $plugin_file;
	private $bp_catched_last_email;

	const MODULE_NAME = 'libravatar-replace';

	const OPTION_LOCAL_CACHE_ENABLED = 'libravatar_replace_cache_enabled';
	const OPTION_LOCAL_CACHE_ENABLED_DEFAULT = 0;

	const OPTION_RETINA_ENABLED = 'libravatar_retina_enabled';
	const OPTION_RETINA_ENABLED_DEFAULT = 0;

	public function __construct($plugin_file)
	{
		$this->plugin_file = $plugin_file;
	}

	public function init()
	{
		load_plugin_textdomain('libravatar-replace', false, dirname(plugin_basename($this->plugin_file)));
	}

	/**
	 * @return bool true if the connection uses SSL
	 */
	private function isSsl()
	{
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
			return true;
		} elseif ($_SERVER['SERVER_PORT'] == 443) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Change Avatar Defaults
	 *
	 * @param array $avatar_defaults
	 * @return mixed
	 */
	public function filterAvatarDefaults($avatar_defaults)
	{
		$avatar_defaults['gravatar_default'] = __('Libravatar Logo', 'libravatar-replace'); // rename accordingly
		return $avatar_defaults;
	}

	/**
	 * Update default avatar links so they will show defaults
	 *
	 * Can be removed when Libravatar will support forcedefault
	 *
	 * @param string $avatar_list
	 * @return string
	 */
	public function filterDefaultAvatarSelect($avatar_list)
	{
		return preg_replace('~/[a-f0-9]{32}~', '/'. str_repeat('0', 32), $avatar_list); // fill hash with zeros
	}

	/**
	 * Create avatar link
	 *
	 * @param string $avatar
	 * @param string|int $id_or_email
	 * @param int $size
	 * @param string $default
	 * @param string $alt
	 * @return string avatar HTML
	 */
	public function filterGetAvatar($avatar, $id_or_email, $size, $default, $alt)
	{
		if (false === $alt) {
			$safe_alt = '';
		} else {
			$safe_alt = esc_attr($alt);
		}

		$email = '';
		if (is_numeric($id_or_email)) {
			$id = (int)$id_or_email;
			$user = get_userdata($id);
			if ($user) {
				$email = $user->user_email;
			}
		} elseif (is_object($id_or_email)) {
			if (!empty($id_or_email->user_id)) {
				$id = (int)$id_or_email->user_id;
				$user = get_userdata($id);
				if ($user) {
					$email = $user->user_email;
				}
			} elseif (!empty($id_or_email->comment_author_email)) {
				$email = $id_or_email->comment_author_email;
			}
		} else {
			$email = $id_or_email;
		}

		$libravatar = $this->getLibravatarClass();

		$options = array();
		$options['algorithm'] = 'md5';
		$options['https'] = $this->isSsl();

		if ($default && $default !== 'gravatar_default') {
			$options['default'] = $default;
		}

		$avatar = $this->getAvatarCode($libravatar, $email, $safe_alt, $options, $size);

		return $avatar;
	}

	/**
	 * @param Services_Libravatar $libravatar
	 * @param $email
	 * @param $alt
	 * @param $options
	 * @param $size
	 * @return string
	 */
	private function getAvatarCode($libravatar, $email, $alt, $options, $size)
	{
		$options['size'] = $size;

		$url = $libravatar->getUrl($email, $options); // get normal size avatar

		if ($this->isRetinaEnabled()) {
			$id = uniqid('libravatar-');

			$options['size'] = $size * 2;

			$url_large = $libravatar->getUrl($email, $options); // get double size avatar

			return <<<HTML
				<style>
					#{$id} {
						background-image: url({$url}) !important;
						background-size: 100% !important;
						padding: 0 !important;
						width: {$size}px;
						height: {$size}px;
					}
				</style>
				<style media="(min-resolution: 1.5dppx)">
					#{$id} { background-image: url({$url_large}) !important; }
				</style>
				<img id="$id" alt="{$alt}" class="avatar avatar-{$size} photo" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" />
HTML;

		} else {
			return "<img alt='{$alt}' src='{$url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}
	}

	/**
	 * There's no way to know email on the url composing so just remember the email in the previous filter
	 *
	 * @param $email
	 * @return mixed
	 */
	public function filterBPCoreGravatarEmail($email)
	{
		$this->bp_catched_last_email = $email;

		return $email;
	}

	/**
	 * Shitcode here :)
	 *
	 * Take the remembered email and get url from it, then extract the host
	 * Unfortunately there's no way to set Libravatar link with federation support more direct
	 *
	 * @return string
	 */
	public function filterBPGravatarUrl()
	{
		$default_host = $this->isSsl() ? 'https://seccdn.libravatar.org/avatar/' : 'http://cdn.libravatar.org/avatar/';

		if (empty($this->bp_catched_last_email)) {
			return $default_host;
		}

		$libravatar = $this->getLibravatarClass();
		$options = array();
		$options['algorithm'] = 'md5';
		$options['https'] = $this->isSsl();
		$url = $libravatar->getUrl($this->bp_catched_last_email, $options);

		preg_match('~^(.*/avatar/)~', $url, $matches);

		return isset($matches[1]) ? $matches[1] : $default_host;
	}

	/**
	 * A factory for the avatar retriever class
	 *
	 * @return Services_Libravatar
	 */
	private function getLibravatarClass()
	{
		if ($this->isLocalCacheEnabled()) {
			return new ServicesLibravatarCached($this->plugin_file);
		} else {
			return new ServicesLibravatarExt();
		}
	}

	/**
	 * Let's put our admin page to the menu
	 */
	public function registerAdminMenu()
	{
		add_submenu_page(
			'options-general.php',
			'Libravatar Replace Settings',
			'Libravatar',
			'administrator',
			self::MODULE_NAME,
			array($this, 'adminPage')
		);
	}

	/**
	 * Tell the admin page what settings are safe to be set
	 */
	public function registerSettings()
	{
		register_setting(self::MODULE_NAME, self::OPTION_LOCAL_CACHE_ENABLED);
		register_setting(self::MODULE_NAME, self::OPTION_RETINA_ENABLED);
	}

	public function registerActions($links, $file)
	{
		if ($file === plugin_basename($this->plugin_file)) {
			$links[] = '<a href="options-general.php?page=libravatar-replace">' . __('Settings') . '</a>';
		}

		return $links;
	}

	/**
	 * Render the admin page
	 */
	public function adminPage()
	{
		include dirname(__FILE__) .'/../views/admin.php';
	}

	/**
	 * Get local cache enabled option
	 *
	 * @return bool
	 */
	private function isLocalCacheEnabled()
	{
		return get_option(self::OPTION_LOCAL_CACHE_ENABLED, self::OPTION_LOCAL_CACHE_ENABLED_DEFAULT) ? true : false;
	}

	/**
	 * Get retina support enabled option
	 *
	 * @return bool
	 */
	private function isRetinaEnabled()
	{
		return get_option(self::OPTION_RETINA_ENABLED, self::OPTION_RETINA_ENABLED_DEFAULT) ? true : false;
	}
}

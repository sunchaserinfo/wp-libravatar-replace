<?php

/**
 * Class LibravatarReplace
 *
 * everything for the plugin to work
 */
class LibravatarReplace
{
	private $plugin_file;
	private $bp_catched_last_email;

	const MODULE_NAME = 'libravatar-replace';

	const OPTION_LOCAL_CACHE_ENABLED = 'libravatar_replace_cache_enabled';
	const OPTION_LOCAL_CACHE_ENABLED_DEFAULT = 0;

	public function __construct($plugin_file)
	{
		$this->plugin_file = $plugin_file;
	}

	public function init()
	{
		load_plugin_textdomain(self::MODULE_NAME, false, dirname(plugin_basename($this->plugin_file)));
	}

	/**
	 * @return bool true if the connection uses SSL
	 */
	private function isSsl()
	{
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
		{
			return true;
		}
		elseif ($_SERVER['SERVER_PORT'] == 443)
		{
			return true;
		}
		else
		{
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
		return preg_replace('~/[a-f0-9]{32}~', '/'.str_repeat('0', 32), $avatar_list); // fill hash with zeros
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
		if (false === $alt)
		{
			$safe_alt = '';
		}
		else
		{
			$safe_alt = esc_attr($alt);
		}

		$email = '';
		if (is_numeric($id_or_email))
		{
			$id = (int)$id_or_email;
			$user = get_userdata($id);
			if ($user)
			{
				$email = $user->user_email;
			}
		}
		elseif (is_object($id_or_email))
		{
			if (!empty($id_or_email->user_id))
			{
				$id = (int)$id_or_email->user_id;
				$user = get_userdata($id);
				if ($user)
				{
					$email = $user->user_email;
				}
			}
			elseif (!empty($id_or_email->comment_author_email))
			{
				$email = $id_or_email->comment_author_email;
			}
		}
		else
		{
			$email = $id_or_email;
		}

		$libravatar = $this->getLibravatarClass();

		$options = array();
		$options['size'] = $size;
		$options['algorithm'] = 'md5';
		$options['https'] = $this->isSsl();

		if ($default && $default !== 'gravatar_default')
		{
			$options['default'] = $default;
		}
		$url = $libravatar->getUrl($email, $options);

		$avatar = "<img alt='{$safe_alt}' src='{$url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

		return $avatar;
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
	 * @param $host
	 * @return string
	 */
	public function filterBPGravatarUrl($host)
	{
		$default_host = $this->isSsl() ? 'https://seccdn.libravatar.org/avatar/' : 'http://cdn.libravatar.org/avatar/';

		if (empty($this->bp_catched_last_email))
		{
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

	private function getLibravatarClass()
	{
		if (get_option(self::OPTION_LOCAL_CACHE_ENABLED, self::OPTION_LOCAL_CACHE_ENABLED_DEFAULT))
		{
			return new ServicesLibravatarCached($this->plugin_file);
		}
		else
		{
			return new ServicesLibravatarExt();
		}
	}

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

	public function registerSettings()
	{
		register_setting(self::MODULE_NAME, self::OPTION_LOCAL_CACHE_ENABLED);
	}

	public function adminPage()
	{
		include dirname(__FILE__) .'/../views/admin.php';
	}
}

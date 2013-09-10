<?php

/**
 * Plugin Name: Libravatar Replace
 * Plugin URI: http://code.sunchaser.info/libravatar
 * Description: Libravatar support for WordPress and BuddyPress
 * Version: 2.0.3
 * Author: Christian Archer
 * Author URI: https://sunchaser.info/
 * License: ISC
 * Initial Author: Gabriel Hautclocq
 * Initial Author URI: http://www.gabsoftware.com/
 */

// security check
if (!defined('WP_PLUGIN_DIR'))
{
	die('There is nothing to see here!');
}

require_once('Services_Libravatar.php');

/**
 * Class LibravatarReplace
 *
 * everything for the plugin to work
 */
class LibravatarReplace
{
	var $bp_catched_last_email;

	/**
	 * @return bool true if the connection uses SSL
	 */
	function isSsl()
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
	function filterAvatarDefaults($avatar_defaults)
	{
		$avatar_defaults['gravatar_default'] = __('Libravatar Logo'); // rename accordingly
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
	function filterDefaultAvatarSelect($avatar_list)
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
	function filterGetAvatar($avatar, $id_or_email, $size, $default, $alt)
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

		$libravatar = new Services_Libravatar();
		$options = array();
		$options['s'] = $size;
		$options['algorithm'] = 'md5';
		$options['https'] = $this->isSsl();
		if ($default && $default !== 'gravatar_default')
		{
			$options['d'] = $default;
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
	function filterBPCoreGravatarEmail($email)
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
	function filterBPGravatarUrl($host)
	{
		$default_host = $this->isSsl() ? 'https://seccdn.libravatar.org/avatar/' : 'http://cdn.libravatar.org/avatar/';

		if (empty($this->bp_catched_last_email))
		{
			return $default_host;
		}

		$libravatar = new Services_Libravatar();
		$options = array();
		$options['algorithm'] = 'md5';
		$options['https'] = $this->isSsl();
		$url = $libravatar->getUrl($this->bp_catched_last_email, $options);

		preg_match('~^(.*/avatar/)~', $url, $matches);

		return isset($matches[1]) ? $matches[1] : $default_host;
	}
}

$libravatar_replace = new LibravatarReplace();

add_filter('get_avatar',                array($libravatar_replace, 'filterGetAvatar'), 10, 5);
add_filter('avatar_defaults',           array($libravatar_replace, 'filterAvatarDefaults'));
add_filter('default_avatar_select',     array($libravatar_replace, 'filterDefaultAvatarSelect'));
add_filter('bp_core_gravatar_email',    array($libravatar_replace, 'filterBPCoreGravatarEmail'));
add_filter('bp_gravatar_url',           array($libravatar_replace, 'filterBPGravatarUrl', 10));

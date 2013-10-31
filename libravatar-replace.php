<?php

/**
 * Plugin Name: Libravatar Replace
 * Plugin URI: http://code.sunchaser.info/libravatar
 * Description: Libravatar support for WordPress and BuddyPress
 * Version: 2.0.4
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

// if file exsists, require it. otherwise assume it's autoload
// WARNING: do not check class existance instead of file or you will crash WordPress if both Libravatar and Libravatar Replace are active
if (is_file(dirname(__FILE__) . '/classes/Services_Libravatar.class.php')) {
	require_once(dirname(__FILE__) . '/classes/Services_Libravatar.class.php');
}

require_once dirname(__FILE__) . '/classes/ServicesLibravatarExt.class.php'; // Services_Libravatar custom extensions
require_once dirname(__FILE__) . '/classes/LibravatarReplace.class.php'; // main plugin class

$libravatar_replace = new LibravatarReplace();

add_filter('get_avatar',                array($libravatar_replace, 'filterGetAvatar'), 10, 5);
add_filter('avatar_defaults',           array($libravatar_replace, 'filterAvatarDefaults'));
add_filter('default_avatar_select',     array($libravatar_replace, 'filterDefaultAvatarSelect'));
add_filter('bp_core_gravatar_email',    array($libravatar_replace, 'filterBPCoreGravatarEmail'));
add_filter('bp_gravatar_url',           array($libravatar_replace, 'filterBPGravatarUrl', 10));

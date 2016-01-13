<?php

/**
 * Plugin Name: Libravatar Replace
 * Plugin URI: http://code.sunchaser.info/libravatar
 * Description: Libravatar support for WordPress and BuddyPress
 * Version: 3.2.0
 * Author: Christian Archer
 * Author URI: https://sunchaser.info/
 * License: ISC
 * Text Domain: libravatar-replace
 * Domain Path: /languages
 */

// security check
if (!defined('WP_PLUGIN_DIR')) {
    die('There is nothing to see here!');
}

// if file exists, require it. otherwise assume it's autoload
// WARNING: do not check class existence instead of file existence or you will crash WordPress if both Libravatar and Libravatar Replace are active
if (is_file(dirname(__FILE__) . '/classes/ServicesLibravatar.class.php')) {
    require_once dirname(__FILE__) . '/classes/ServicesLibravatar.class.php';
}

require_once dirname(__FILE__) . '/classes/ServicesLibravatarExt.class.php'; // Services_Libravatar custom extensions
require_once dirname(__FILE__) . '/classes/ServicesLibravatarCached.class.php'; // Services_Libravatar local caching extension
require_once dirname(__FILE__) . '/classes/LibravatarReplace.class.php'; // main plugin class

$libravatarReplace = new LibravatarReplace(__FILE__);

add_action('init',                      array($libravatarReplace, 'init'));
add_action('admin_menu',                array($libravatarReplace, 'registerAdminMenu'), 0);
add_action('admin_init',                array($libravatarReplace, 'registerSettings'));
add_filter('plugin_action_links',       array($libravatarReplace, 'registerActions'), 10, 2);

add_filter('get_avatar',                array($libravatarReplace, 'filterGetAvatar'), 10, 5);
add_filter('avatar_defaults',           array($libravatarReplace, 'filterAvatarDefaults'));
add_filter('default_avatar_select',     array($libravatarReplace, 'filterDefaultAvatarSelect'));
add_filter('bp_core_gravatar_email',    array($libravatarReplace, 'filterBPCoreGravatarEmail'));
add_filter('bp_gravatar_url',           array($libravatarReplace, 'filterBPGravatarUrl', 10));

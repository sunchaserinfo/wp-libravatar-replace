=== Libravatar Replace ===
Contributors: sunchaserinfo
Tags: libravatar, avatar, support, user, email, pseudo, picture, image, buddypress
Requires at least: 2.7
Tested up to: 3.6
Stable tag: trunk

Replaces Gravatar with Libravatar in your WordPress installation.

== Description ==

<p>
Adds <a href="http://www.libravatar.org">Libravatar</a> avatars support to your WordPress installation. Libravatar is an alternative to Gravatar and its API is mostly compatible.
</p>

<p>
<b>Warning!</b> The plugin is incompatible with it's predecessor, the <b>Libravatar</b> plugin. Please remove or disable it before installing this plugin.
</p>

== Installation ==

<p>Just extract the plugin directory into your wp-content/plugins directory.</p>

= via Composer ==

(available since 2.0.3.1)

If you are using Composer to manage your plugins, add PHP Pear repo (for Services_Libravatar) and
plugin's BitBucket repo (mercurial) and then require sunchaser/libravatar package.
You should use composer/installers to ensure that the plugin will be installed to the correct path.

    {
        "repositories": [
            {
                    "type": "pear",
                    "url": "http://pear.php.net"
            },
            {
                    "type": "vcs",
                    "url": "https://bitbucket.org/sunchaser/libravatar"
            }
        ],
        "require": {
            "sunchaser/libravatar": "dev-master",
            "composer/installers": "~1.0"
        }
    }

== Frequently Asked Questions ==
= What are the requirements of this plugin? =
PHP 5.2.4, WordPress 3.6.

The plugin is tested down to WordPress 2.7 but I will not support anything but current and prevoius releases. The plugin will not work under WordPress 2.6 and earlier.

== Thanks to ==
* Gabriel Hautclocq, author of the initial plugin
* François Marier (For his hard work in the Libravatar project and his bug fixes)

== Changelog ==

= 2.0.3.1 =
* Build for WordPress SVN via Composer
* Allow installation via Composer
* Since there are no changes to the plugin itself, it won't be committed to the WP plugin repo

= 2.0.3 =
* Default images in admin page fix

= 2.0.2 =
* No special blank treatment - it just works
* Public WordPress.org release

= 2.0.1 =
* 'blank' Gravatar default fixed and reimplemented

= 2.0.0 =
* Updated Services_Libravatar with SRV port discovery fix
* The plugin tries to completely replace Gravatar with Libravatar
* Beta support for BuddyPress

= 1.0.4 =
* Support for different fallbacks for the Libravatar

= 1.0.3 =
* Initial fork of the Libravatar plugin

== Upgrade Notice ==

= 2.0.0 =
* Thank you for using the Libravatar Replace plugin!

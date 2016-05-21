# Libravatar Replace #
**Contributors:** sunchaserinfo  
**Tags:** libravatar, avatar, email, picture, image, buddypress, retina  
**Requires at least:** 2.8  
**Tested up to:** 4.5  
**Stable tag:** trunk  
**License:** ISC  

Replaces Gravatars with Libravatars in your WordPress installation.

## Description ##

Replaces Gravatars with [Libravatars](http://www.libravatar.org/) in your WordPress installation.
Libravatar is an alternative to Gravatar and its API is mostly compatible.

**Warning!** The plugin is incompatible with it's predecessor, the
**[Libravatar](https://wordpress.org/plugins/libravatar/)** plugin. Please remove or disable it before installing this plugin.

## Installation ##

Just extract the plugin directory into your *wp-content/plugins* directory.

### via Composer ###

(available since 2.0.3.1)

If you are using Composer to manage your plugins, require sunchaser/wp-libravatar-replace package.
You should use composer/installers to ensure that the plugin will be installed to the correct path.

    {
        "require": {
            "sunchaser/wp-libravatar-replace": "dev-master",
            "composer/installers": "~1.0"
        }
    }

## Frequently Asked Questions ##
### What are the requirements of this plugin? ###
PHP 5.2.4, WordPress 4.3.

The plugin is tested down to WordPress 2.8 but I will not support anything but current and prevoius releases.
The plugin will not work under WordPress 2.7 and earlier.

## Screenshots ##

###1. Libravatars are shown instead of Gravatars###
![Libravatars are shown instead of Gravatars](https://ps.w.org/libravatar-replace/assets/screenshot-1.png)

###2. Libravatars are configured on the same page as Gravatars, rating however is ignored###
![Libravatars are configured on the same page as Gravatars, rating however is ignored](https://ps.w.org/libravatar-replace/assets/screenshot-2.png)

###3. Specific Libravatar settings page###
![Specific Libravatar settings page](https://ps.w.org/libravatar-replace/assets/screenshot-3.png)


## Thanks to ##
* Gabriel Hautclocq, author of the initial plugin
* François Marier (For his hard work in the Libravatar project and his bug fixes)

## License Info ##

Libravatar Replace is licensed under ISC license. It also uses
some code under separate licenses.

### Libravatar Replace ###

    Copyright (c) 2011, Gabriel Hautclocq
    Copyright (c) 2013, Christian Archer

    Permission to use, copy, modify, and/or distribute this software
    for any purpose with or without fee is hereby granted, provided
    that the above copyright notice and this permission notice appear
    in all copies.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL
    WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL
    THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT,
    OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING
    FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT,
    NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION
    WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.

### Third Party Libraries ###

* Services_Libravatar: MIT

## Changelog ##

Full changelog can be found on [GitHub](https://github.com/sunchaserinfo/wp-libravatar-replace/releases)

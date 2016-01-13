# Libravatar Replace #
**Contributors:** sunchaserinfo  
**Tags:** libravatar, avatar, email, picture, image, buddypress, retina  
**Requires at least:** 2.8  
**Tested up to:** 4.4  
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
some code under separate licenses

### Libravatar Replace ###

This license covers the difference between Libravatar and Libravatar Replace

    Copyright © 2013 Christian Archer

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

### Libravatar ###

Libravatar Replace is heavily based on the earlier Libravatar plugin

    Copyright (c) 2011, Gabriel Hautclocq

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

### Services_Libravatar ###

The major component of the plugin is Services_Libravatar PHP library

    The MIT License

    Copyright (c) 2011 Services_Libravatar committers.

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.

## Changelog ##

### 3.2.0 ###
* We are now on GitHub!
* Retina support moved from crazy styles to srcset
* Retina support is now a core function, option removed

### 3.1.2 ###
* Fix smooth images in Twenty Thirteen

### 3.1.1 ###
* Fix avatar icon in the header

### 3.1.0 ###
* Retina support (experimental)

### 3.0.0 ###
* Optional local cache (experimental)
* Options page
* Translations

### 2.0.4.1 ###
* Add a readme inside the build system
* Add a section for license data

### 2.0.4 ###
* Some refactoring (move classes to the separate files)
* Now we use vanilla Services_Libravatar, created compatibility class ServicesLibravatarExt

### 2.0.3.1 ###
* Build for WordPress SVN via Composer
* Allow installation via Composer
* Since there are no changes to the plugin itself, it won't be committed to the WP plugin repo

### 2.0.3 ###
* Default images in admin page fix

### 2.0.2 ###
* No special blank treatment - it just works
* Public WordPress.org release

### 2.0.1 ###
* 'blank' Gravatar default fixed and reimplemented

### 2.0.0 ###
* Updated Services_Libravatar with SRV port discovery fix
* The plugin tries to completely replace Gravatar with Libravatar
* Beta support for BuddyPress

### 1.0.4 ###
* Support for different fallbacks for the Libravatar

### 1.0.3 ###
* Initial fork of the Libravatar plugin

## Upgrade Notice ##

### 3.1.0 ###
You may want to enable the Retina support in the settings

### 2.0.0 ###
* Thank you for using the Libravatar Replace plugin!

### 3.0.0 ###
* An optional local cache for the avatars is added

# CHANGELOG

## 3.3.0

* Use the WP Object Cache to cache DNS responses (Fix [#2])

[#2]: https://github.com/sunchaserinfo/wp-libravatar-replace/issues/2

## 3.2.2

* Updated plugin homepage URL

## 3.2.1

* Now the plugin ignores unknown default values for default image (Fix [#1])

[#1]: https://github.com/sunchaserinfo/wp-libravatar-replace/issues/1

## 3.2.0

* We are now on GitHub!
* Retina support moved from crazy styles to srcset
* Retina support is now a core function, option removed
* Composer name changed to wp-libravatar-replace

## 3.1.2

* Fix smooth images in Twenty Thirteen

## 3.1.1

* Fix avatar icon in the header

## 3.1.0

* Retina support (experimental)

## 3.0.0

* Optional local cache (experimental)
* Options page
* Translations

## 2.0.4.1

* Add a readme inside the build system
* Add a section for license data

## 2.0.4

* Some refactoring (move classes to the separate files)
* Now we use vanilla Services_Libravatar, created compatibility class ServicesLibravatarExt

## 2.0.3.2

* Return Libravatar confilct avoider

## 2.0.3.1

* Build for WordPress SVN via Composer
* Allow installation via Composer
* Since there are no changes to the plugin itself, it won't be committed to the WP plugin repo

## 2.0.3

* Default images in admin page fix

## 2.0.2

* No special blank treatment - it just works
* Public WordPress.org release

## 2.0.1

* 'blank' Gravatar default fixed and reimplemented

## 2.0.0

* Updated Services_Libravatar with SRV port discovery fix
* The plugin tries to completely replace Gravatar with Libravatar
* Beta support for BuddyPress

## 1.0.4

First forked release, previous version was [Libravatar 1.0.3](https://wordpress.org/plugins/libravatar/)
* Support for different fallbacks for the Libravatar

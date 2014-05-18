#!/usr/bin/php

<?php

/**
 * Build system for the Libravatar Replace WordPress plugin
 * Copyright © 2013, Christian Archer <chrstnarchr@aol.com>
 *
 *      Licensed under the Apache License, Version 2.0 (the "License");
 *      you may not use this file except in compliance with the License.
 *      You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *      Unless required by applicable law or agreed to in writing, software
 *      distributed under the License is distributed on an "AS IS" BASIS,
 *      WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *      See the License for the specific language governing permissions and
 *      limitations under the License.
 *
 * Here's the dilemma:
 * 1) It's a bad idea to store external libraries in your VCS
 * 2) All files should be included into the WordPress Plugin SVN
 *
 * So let's make one small script that will build the proper structure
 * for SVN while leaving the Services_Libravatar library out of our
 * main repository on BitBucket
 *
 * The script uses Composer so minimum PHP version should be 5.3.2
 * however the script is created only for author's purpose so
 * it hadn't been tested only on PHP 5.5.0+. Sorry if your system
 * is outdated :) And it's UNIX-only
 *
 * The plugin however should run on minimal requirements of
 * the current version of WordPress (РHP 5.2.4+)
 */

$current_dir        = __DIR__;
$base_dir           = dirname($current_dir);
$svn_dir            = $current_dir . '/svn';
$svn_assets_dir     = $svn_dir . '/assets';
$svn_trunk_dir      = $svn_dir . '/trunk';
$svn_classes_dir    = $svn_trunk_dir . '/classes';
$svn_cache_dir      = $svn_trunk_dir . '/cache';
$svn_views_dir      = $svn_trunk_dir . '/views';
$svn_lang_dir       = $svn_trunk_dir . '/languages';

//install composer
if (is_file('composer.phar')) {
	print_message('Updating composer');
    run_in_dir($current_dir, 'php composer.phar self-update');
} else {
	print_message('Installing composer');
	run_in_dir($current_dir, 'curl -sS https://getcomposer.org/installer | php');
}

print_message('Installing dependencies');

run_in_dir($base_dir, 'php build/composer.phar install');

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require($base_dir . '/vendor/autoload.php');

print_message('Clearing svn dirs');

clean_or_create_dir($svn_dir);
clean_or_create_dir($svn_assets_dir);
clean_or_create_dir($svn_trunk_dir);
clean_or_create_dir($svn_classes_dir);
clean_or_create_dir($svn_cache_dir);
clean_or_create_dir($svn_views_dir);
clean_or_create_dir($svn_lang_dir);

print_message('Updating assets');

run_in_dir($base_dir, "cp -v assets/* $svn_assets_dir");

print_message('Updating files');

run_in_dir($base_dir, "cp -v libravatar-replace.php $svn_trunk_dir");
run_in_dir($base_dir, "cp -v readme.txt $svn_trunk_dir");
run_in_dir($base_dir, "cp -v LICENSE $svn_trunk_dir");
run_in_dir($base_dir, "cp -v README.md $svn_trunk_dir");

run_in_dir($base_dir, "cp -v classes/* $svn_classes_dir");
run_in_dir($base_dir, "cp -v cache/* $svn_cache_dir");
run_in_dir($base_dir, "cp -v views/* $svn_views_dir");

run_in_dir(__DIR__, './build_lang.sh');
run_in_dir($base_dir, "cp -v languages/* $svn_lang_dir");

$services_libravatar = $loader->findFile('Services_Libravatar');

run_in_dir($base_dir, "cp -v $services_libravatar $svn_classes_dir/ServicesLibravatar.class.php");

print_message('If nothing failed, the package for WordPress Plugins SVN is ready');

function print_message($msg)
{
	echo PHP_EOL;
	echo '[Libravatar Replace Build] ';
	echo $msg;
	echo PHP_EOL;
}

function run_in_dir($dir, $command)
{
	echo `cd $dir && $command`;
}

function clean_or_create_dir($dir)
{
	if (is_dir($dir) === false)
	{
		mkdir($dir);
	} else {
		run_in_dir($dir, 'rm -vf *'); // remove all __files__ in the directory
	}
}

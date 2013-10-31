#!/usr/bin/php

<?php

$current_dir        = __DIR__;
$base_dir           = dirname($current_dir);
$svn_dir            = $current_dir . '/svn';
$svn_assets_dir     = $svn_dir . '/assets';
$svn_trunk_dir      = $svn_dir . '/trunk';
$svn_classes_dir    = $svn_trunk_dir . '/classes';

//install composer
if (is_file('composer.phar')) {
	print_message('Updating composer');
    run_in_dir($current_dir, 'php composer.phar self-update');
} else {
	print_message('Installing composer');
	run_in_dir($current_dir, 'curl -sS https://getcomposer.org/installer | php');
}

print_message('Installing dependencies');

run_in_dir ($base_dir, 'php build/composer.phar install');

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require($base_dir . '/vendor/autoload.php');

print_message('Clearing svn dirs');
if (is_dir($svn_dir) === false)
{
	mkdir($svn_dir);
}

if (is_dir($svn_assets_dir) === false)
{
	mkdir($svn_assets_dir);
} else {
	run_in_dir($svn_assets_dir, 'rm -vf *'); // remove all __files__ in the directory
}

if (is_dir($svn_trunk_dir) === false)
{
	mkdir($svn_trunk_dir);
} else {
	run_in_dir($svn_trunk_dir, 'rm -vf *'); // remove all __files__ in the directory
}

if (is_dir($svn_classes_dir) === false)
{
	mkdir($svn_classes_dir);
} else {
	run_in_dir($svn_classes_dir, 'rm -vf *'); // remove all __files__ in the directory
}

print_message('Updating assets');

run_in_dir($base_dir, "cp -v assets/* $svn_assets_dir");

print_message('Updating files');

run_in_dir($base_dir, "cp -v libravatar-replace.php $svn_trunk_dir");
run_in_dir($base_dir, "cp -v readme.txt $svn_trunk_dir");

run_in_dir($base_dir, "cp -v classes/* $svn_classes_dir");

$services_libravatar = $loader->findFile('Services_Libravatar');

run_in_dir($base_dir, "cp -v $services_libravatar $svn_classes_dir/Services_Libravatar.class.php");

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

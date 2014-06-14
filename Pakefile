<?php

pake_desc('Update markdown readme');
pake_task('readme');

function run_readme()
{
	pake_sh('vendor/bin/wp2md convert -i readme.txt -o README.md');
}

pake_desc('Build language files');
pake_task('lang');

function run_lang()
{
	$dir = new DirectoryIterator(__DIR__ . '/languages');

	foreach ($dir as $file) {
		/** @var $file DirectoryIterator */
		if ($file->getExtension() === 'po') {
			$po_file = escapeshellarg($file->getPathname());
			$mo_file = escapeshellarg($file->getPath() .'/'. $file->getBasename('.po') . '.mo');

			pake_sh("msgfmt $po_file -o $mo_file");
		}
	}
}

pake_desc('Build project for WordPress SVN');
pake_task('build');

function run_build()
{
	$base_dir           = __DIR__;

	$assets_dir         = $base_dir . '/assets';
	$classes_dir        = $base_dir . '/classes';
	$cache_dir          = $base_dir . '/cache';
	$views_dir          = $base_dir . '/views';
	$lang_dir           = $base_dir . '/languages';

	$svn_dir            = $base_dir . '/build/svn';
	$svn_trunk_dir      = $svn_dir . '/trunk';

	$svn_assets_dir     = $svn_dir . '/assets';
	$svn_classes_dir    = $svn_trunk_dir . '/classes';
	$svn_cache_dir      = $svn_trunk_dir . '/cache';
	$svn_views_dir      = $svn_trunk_dir . '/views';
	$svn_lang_dir       = $svn_trunk_dir . '/languages';

	pake_echo('Prepare trunk and assets dirs');
	pake_mkdirs($svn_trunk_dir);
	pake_mkdirs($svn_assets_dir);
	pake_remove(pakeFinder::type('any'), $svn_trunk_dir);
	pake_remove(pakeFinder::type('any'), $svn_assets_dir);

	pake_echo('Build languages');
	run_lang();

	pake_echo('Copy assets');
	pake_mirror(pakeFinder::type('file'), $assets_dir, $svn_assets_dir);

	pake_echo('Copy plugin files');
	pake_mirror([
		'libravatar-replace.php',
		'readme.txt',
		'LICENSE',
		'README.md',
	], $base_dir, $svn_trunk_dir);
	pake_mirror(pakeFinder::type('file'), $classes_dir, $svn_classes_dir);
	pake_mirror(pakeFinder::type('file'), $cache_dir,   $svn_cache_dir);
	pake_mirror(pakeFinder::type('file'), $views_dir,   $svn_views_dir);
	pake_mirror(pakeFinder::type('file'), $lang_dir,    $svn_lang_dir);

	pake_echo('Retrieve Services_Libravatar class');
	$loader = require($base_dir . '/vendor/autoload.php');
	$services_libravatar = $loader->findFile('Services_Libravatar');
	pake_copy($services_libravatar, $svn_classes_dir .'/ServicesLibravatar.class.php');

	pake_echo('done');
}

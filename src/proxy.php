<?php
/**
  A proxy file for Gravatar defaults that are not supported by Libravatar
  created for Libravatar Replace v2.0.1
 */

$request = $_SERVER['REQUEST_URI'];

$success = preg_match('~/([\w\d]+)/(\w+)/(\d+).png$~', $request, $matches); // get hash, default, and size

if ($success === false)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

$link = 'https://secure.gravatar.com/avatar/'. $matches[1] .'?d='. $matches[2] .'&s='. $matches[3];

header('Location: '. $link);

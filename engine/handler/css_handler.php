<?php

/**
 * @file
 * 
 * Output the virtual CSS "/style.css" file based on template.
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */
require_once(dirname(dirname(__FILE__)) . '/start.php');

$css = \home_io\core\Template::v('css');

header('Etag: ' . md5($css));
header('Content-Length: ' . strlen($css));
header('Content-Type: text/css');

// We never want this to expire, since we're going to be changing the version on CSS updates
header('Expires: ' . date('r', strtotime("+6 months")), true);
header("Pragma: public", true);
header("Cache-Control: public", true);

echo $css;


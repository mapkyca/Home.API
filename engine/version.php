<?php

/**
 * @file
 * Version details.
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */
global $version, $release;

$version = 2013060501; // System readable version YYYYMMDDNN (where NN is a daily counter)
$release = "1.0"; // Human readable 
	
header("X-Home.IO-Build: v$release($version)");
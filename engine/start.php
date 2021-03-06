<?php

/**
 * @file
 * 
 * Startup file
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */
/**
 * \mainpage 
 * Welcome to Home.API, a pluggable API for your house!
 * 
 * Important code concepts
 * =======================
 * 
 * * The engine is booted by Site::init(), which is passed the base configuration
 * * Various subsystems are booted by a getInstance wrapper hooked into a factory callback (to avoid loading The World if not needed)
 * * If you *must* store something in $_SESSION, store IDs not objects. Space is at a premium since handling will likely be replaced by client side storage at some point (http://www.marcus-povey.co.uk/2013/03/18/encrypted-client-side-php-sessions/)
 * * Don't modify settings.php for your local dev settings, create a settings.localhost.php and add your settings there.
 * * Output translations using i18n::w() and views by Template::v(), make sure you sanitise user provided output using Template::sanitiseOutput()
 * * Pages can be physical or virtual, created by Page::create()
 * * Look at Site::$runtime->isAjaxCall to find out if you're being called by ajax.
 */
// Library files to include in order
require_once(dirname(__FILE__) . "/version.php");
require_once(dirname(dirname(__FILE__)) . "/config/settings.php");

// Include any domain specific configuration
$settings_file = dirname(dirname(__FILE__)) . "/config/settings.{$_SERVER['SERVER_NAME']}.php"; 
if (file_exists($settings_file))
    require_once($settings_file);

// Register an autoloader
spl_autoload_register(function($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = dirname(__FILE__) . '/classes/' . $class . '.class.php';
    if (file_exists($file))
        include_once($file);
});

// Initialise the site
global $CONFIG;
\home_api\Home::init($CONFIG);


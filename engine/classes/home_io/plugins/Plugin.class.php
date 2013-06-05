<?php

/**
 * @file
 * Base plugin class.
 * 
 * @package plugins
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_io\plugins {
    
    /**
     * Plugin root class.
     */
    abstract class Plugin {
    
        
        
        
        /**
         * Autoload class files
         */
        public static function __plugin_class_autoloader($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file = \home_io\Home::$config->docroot. 'plugins/' . $class . '/start.php'; 
            if (file_exists($file))
                include_once($file);
        }
        
        public static function init() {
            
            // Register plugin class autoloader
            spl_autoload_register(array('\home_io\plugins\Plugin', '__plugin_class_autoloader'));
        }
        
    }
    
}
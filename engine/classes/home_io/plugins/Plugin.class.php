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
            $file_base = \home_io\Home::$config->docroot. 'plugins/' . $class . '/';
            if (file_exists($file_base . 'start.php')) {
                include_once($file_base . 'start.php');
                
                // Now boot languages etc
            }
        }
        
        public static function init() {
            
            // Register plugin class autoloader
            spl_autoload_register(array('\home_io\plugins\Plugin', '__plugin_class_autoloader'));
        }
        
    }
    
}
<?php

/**
 * @file
 * Base plugin class.
 * 
 * @package plugins
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_io\plugins {

    use home_io\templates\Template as Template;

    /**
     * Plugin root class.
     */
    abstract class Plugin {
        // TODO: Set configuration / variable commands.

        /**
         * Generic way for a plugin to summarise itself.
         * @param array $vars
         * @return type 
         */
        public function view(array $vars = null) {
            $class = strtolower(get_class($this));

            if (!$vars)
                $vars = array();
            $vars['object'] = $this;

            $content = Template::v("data/plugin/$class", $vars);
            if ($content)
                return $content;

            $content = Template::v('data/plugin/__default', $vars);
            if ($content)
                return $content;

            return false;
        }

        /**
         * Autoload class files
         */
        public static function __plugin_class_autoloader($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file_base = \home_io\Home::$config->docroot . 'plugins/' . $class . '/';
            if (file_exists($file_base . 'start.php')) {
                include_once($file_base . 'start.php');

                // TODO Now boot languages etc
            }
        }

        public static function init() {

            // Register plugin class autoloader
            spl_autoload_register(array('\home_io\plugins\Plugin', '__plugin_class_autoloader'), false);
        }

    }

}
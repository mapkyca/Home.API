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

namespace home_api\plugins {

    use home_api\templates\Template as Template;

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
            $class = get_class($this);
            if (preg_match('@\\\\([\w]+)$@', $class, $matches)) {
                $class = $matches[1];
            }

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
         * Render the data object using the views system, using defaults.
         */
        public function __toString() {
            return $this->view();
        }

        /**
         * When passed API call and definition details, this function will use reflection and return
         * a new instance of the appropriate class, initialised with the API arguments got from the definition.
         * @param array $definition
         */
        public static function getInstance(array $definition) {
            // Build reflection class
            $mirror = new \ReflectionClass($definition['class']);

            // Construct constructor parameters
            $creation_parameters = array();
            $constructor = $mirror->getConstructor();
            if (!$constructor)
                throw new PluginException(i18n::w('plugin:exception:no_constructor', array($definition['class'])));
            if ($parameters = $constructor->getParameters()) {
                foreach ($parameters as $param) {
                    $value = $definition[$param->name];
                    if ((!$value) && ($param->isDefaultValueAvailable())) // No value, but coded default present
                        $value = $param->getDefaultValue();
                    if (!$value)
                        throw new PluginException(i18n::w('plugin:exception:missing_construction_parameter', array($param->name, $definition['class']))); // Still no value, throw an exception


                        
                    // We have a value, save it.
                    $creation_parameters[] = $value;
                }
            }

            // Create object with constructed parameters
            if (count($creation_parameters))
                $object = $mirror->newInstanceArgs($creation_parameters);
            else
                $object = $mirror->newInstance();

            if (!$object)
                throw new PluginException(i18n::w('plugin:exception:could_not_create_instance', array($definition['class'])));

            return $object;
        }

        /**
         * Expose api.
         * Return an array of method names to expose.
         */
        abstract public function expose();
        
        /**
         * Autoload class files
         */
        public static function __plugin_class_autoloader($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file_base = \home_api\Home::$config->docroot . 'plugins/' . $class . '/';
            if (file_exists($file_base . 'start.php')) {
                include_once($file_base . 'start.php');

                // Tell everyone we've loaded a plugin, allow for registration of translations etc
                \home_api\core\Log::debug("Plugin registered: $class ($file_base)");
                \home_api\core\Events::trigger('plugin', 'registered', array(
                    'class' => $class,
                    'file_base' => $file_base
                ));
            }
        }

        public static function init() {

            // Register plugin class autoloader
            spl_autoload_register(array('\home_api\plugins\Plugin', '__plugin_class_autoloader'), false);
        }

    }

}
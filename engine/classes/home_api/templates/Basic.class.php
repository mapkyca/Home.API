<?php

/**
 * @file
 * Default site templating engine.
 * 
 * @package templates
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_api\templates {

    /**
     * Default template system.
     * This can of course be replaced by something else.
     */
    class Basic extends Template {

        private $template_path;

        /**
         * Default template constructor.
         * @param string|array $template_path Path(s) of template hierachies to load. If this is an array, then each hierachy is searched in order, and the first matching view displayed. This way you can extend the base and keep different themes separate.
         */
        public function __construct($template_path) {

            // Register paths
            $this->pushPath($template_path);
            
            // Plugin boot, register new templates
            Events::register('plugin', 'registered', array($this, '__pluginRegistered'));
            
        }
        
        /**
         * Load up a plugin's templates when registered.
         * @param type $namespace
         * @param type $event
         * @param type $parameters
         */
        public function __pluginRegistered($namespace, $event, $parameters) { 
            $this->pushPath($parameters['file_base'] . 'templates/');
        }
        
        /**
         * Register a template path.
         * Push a template path to the top of the stack.
         * @param type $template_path
         */
        public function pushPath($template_path) {
            
            // Make sure we have a consistent type
            if (!is_array($template_path))
                $template_path = array($template_path);
            
            // Make sure we've created storage
            if (!isset($this->template_path))
                $this->template_path = array();
            
            // Sanitise paths
            foreach ($template_path as $index => $path)
                $template_path[$index] = rtrim($path, '/') . '/';
            
            $this->template_path = $template_path + $this->template_path;
            
        }

        public function view($view, array $vars = null, $viewtype = 'default') {
            // Allow viewtype override
            $viewtype = \home_api\core\Input::get('_vt', $viewtype);

            if (empty($vars))
                $vars = array();

            // Bring in config 
            if (isset(\home_api\Home::$config))
                $vars['config'] = \home_api\Home::$config;

            // Bring in runtime
            $vars['runtime'] = \home_api\Home::$runtime;

            $pre = $main = $post = null;
            
            //ob_start();
            if ($this->viewExists($view, $viewtype)) {
                
                // Prepend view
                ob_start();
                \home_api\core\Events::trigger("view:$viewtype:".str_replace('/',':',$view), 'prepend', array_merge($vars, array('return' => true)));
                $pre = ob_get_clean();

                ob_start();
                foreach ($this->template_path as $base) {
                   
                    // Include base view
                    if (file_exists($base . "$viewtype/$view.php")) {
                        include($base . "$viewtype/$view.php");
                        break;
                    }
                    
                }
                $middle = ob_get_clean();
                
                // Extend view 
                ob_start(); 
                \home_api\core\Events::trigger("view:$viewtype:".str_replace('/',':',$view), 'extend', array_merge($vars, array('return' => true)));
                $post = ob_get_clean();
                
            } else {
                \home_api\core\Log::warning("Template $viewtype/$view could not be found.");
            }

            return $pre . $middle/*ob_get_clean()*/ . $post;
        }

        public function viewExists($view, $viewtype = 'default') {
            foreach ($this->template_path as $base) { 
                if (file_exists($base . "$viewtype/$view.php"))
                    return true;
            }

            // Now see if this has been "prepended"
            if (\home_api\core\Events::exists("view:$viewtype:".str_replace('/',':',$view), 'prepend'))
                    return true;
            
            // Now see if this has been "extended"
            if (\home_api\core\Events::exists("view:$viewtype:".str_replace('/',':',$view), 'extend'))
                    return true;
            
            return false;
        }

        public function outputPage($title, $body, array $vars = null, $viewtype = 'default', $return_value = false) {
            // Draw the page

            if (!$vars)
                $vars = array();
            $output = $this->view('page/shell', array(
                'title' => $title,
                'body' => $body
                    ) + $vars
            );

            if (!$return_value) {

                // End session BEFORE we output any data
                session_write_close();

                // Break long output to avoid a apache performance bug							
                $split_output = str_split($output, 1024);

                foreach ($split_output as $chunk)
                    echo $chunk;

                exit;
            }
            else
                return $output;
        }

        /**
         * Basic XSS sanitisation.
         * TODO: More advanced output sanitisation.
         * @param type $text
         */
        public function sanitiseOutput($text) {
            return htmlentities($text, ENT_QUOTES, 'UTF-8');
        }

    }

}
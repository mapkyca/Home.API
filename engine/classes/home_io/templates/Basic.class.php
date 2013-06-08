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

namespace home_io\templates {

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

            if (!is_array($template_path))
                $this->template_path = array($template_path);
            else
                $this->template_path = $template_path;

            // Sort paths
            foreach ($this->template_path as $index => $path)
                $this->template_path[$index] = rtrim($path, '/') . '/';
        }

        public function view($view, array $vars = null, $viewtype = 'default') {
            // Allow viewtype override
            $viewtype = \home_io\core\Input::get('_vt', $viewtype);

            if (empty($vars))
                $vars = array();

            // Bring in config 
            if (isset(\home_io\Home::$config))
                $vars['config'] = \home_io\Home::$config;

            // Bring in runtime
            $vars['runtime'] = \home_io\Home::$runtime;

            $pre = $main = $post = null;

            if ($this->viewExists($view, $viewtype)) {
                foreach ($this->template_path as $base) {
                    // Prepend view
                    ob_start();
                    \home_io\core\Events::trigger("view:$viewtype:".str_replace('/',':',$view), 'prepend', array_merge($vars, array('return' => true)));
                    $pre = ob_get_clean();
                    
                    // Include base view
                    ob_start();
                    if (file_exists($base . "$viewtype/$view.php")) {
                        include($base . "$viewtype/$view.php");
                        break;
                    }
                    $main = ob_get_clean();
                    
                    // Extend view 
                    ob_start();
                    \home_io\core\Events::trigger("view:$viewtype:".str_replace('/',':',$view), 'extend', array_merge($vars, array('return' => true)));
                    $post = ob_get_clean();
                }
            } else {
                \home_io\core\Log::warning("Template $viewtype/$view could not be found.");
            }

            return $pre.$main.$post;
        }

        public function viewExists($view, $viewtype = 'default') {
            foreach ($this->template_path as $base) { 
                if (file_exists($base . "$viewtype/$view.php"))
                    return true;
            }

            // Now see if this has been "prepended"
            if (\home_io\core\Events::exists("view:$viewtype:".str_replace('/',':',$view), 'prepend'))
                    return true;
            
            // Now see if this has been "extended"
            if (\home_io\core\Events::exists("view:$viewtype:".str_replace('/',':',$view), 'extend'))
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
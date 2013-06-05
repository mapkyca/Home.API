<?php

/**
 * @file
 * API and api manifest loader
 * 
 * @package api
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_io\api {
    
    /**
     * The API loader
     */
    abstract class API {
        
        /// API Definition
        private static $api;
        
        /// Base path
        private static $basepath;
    
        /**
         * Parse an API definition and generate the API.
         * 
         * An api definition file is a file consisting of one or more API configurations, separated by one or more blank lines.
         * 
         * A definition begins with path to link the API up to, basically the GET path you want the api exposed as.
         * The next lines should contain the class to load, and any parameters in a colon separated form, with each tuple appearing on a new line, e.g.
         * 
         * /my/api/definition
         *      class: \namespace\to\MyAPIClass
         *      param1: value
         *      param2: value
         * 
         * /my/second/api/definition
         *      class: \namespace\to\SecondAPIClass
         *      param1: value
         * 
         * 
         * @param type $filename
         */
        protected static function parseAPIConf($filename) {
            
            // Read and parse API definition file
            $api = array();
            $current = null;
            $f = fopen($filename, 'r');
            while (!feof($f)) {
                $line = trim(fgets($f));
                
                // Line of data
                if (strlen($line) > 0)
                {
                    if (!$current)
                        $current = $line; // First line, must be the endpoint def
                    else
                    {
                        // Not the first line, tokenise the parameters
                        $params = explode(':',$line, 2); // Tokenise parameters
                        $key = trim($params[0]);
                        $value = trim($params[1]);
                        
                        // Create definition entry if not already there
                        if (!is_array($api[$current]))
                            $api[$current] = array();
                        
                        // Set value of api definition key
                        $api[$current][$key] = $value;
                    }
                }
                else 
                    $current = null;
                
            }
            fclose($f);
            
            // Now process the definition
            foreach ($api as $endpoint => $definition)
            {
                self::register($endpoint, $definition);
            }
            
        }
        
        /**
         * Register an API definition.
         * @param type $endpoint
         * @param type $definition
         */
        public static function register($endpoint, $definition) {
            
            // Create array of not created
            if (!is_array(self::$api))
                self::$api = array();
            
            // Validate definition
            if (!isset($definition['class'])) 
                throw new APIException(\home_io\i18n\i18n::w ('api:exception:class_not_specified'));

            if (!class_exists($definition['class'])) 
                throw new APIException(\home_io\i18n\i18n::w ('api:exception:class_not_found'));

            // If we've got here, the class has been specified and exists, so its safe to link it up
            self::$api[$endpoint] = $definition;
        }
        
        /**
         * Initialise an API.
         * Initialises an API, loading the relevant descriptions from an API definition file.
         * @param type $path_to_api_definitions
         */
        public static function init($path_to_api_definitions) {
            
            // Save base path
            self::$basepath = $path_to_api_definitions;

            // Load all conf files
            if ($handle = opendir(self::$basepath)) {
                    while ($api_def = readdir($handle)) {
                        // must be directory and not begin with a .
                        if ((substr($api_def, 0, 1) !== '.') && (!is_dir(self::$basepath . $api_def)) && (strpos($api_def, '.conf')!==false)) {
                                self::parseAPIConf(self::$basepath . $api_def);
                        }
                    }
            }
                        
        }
        
    }
    
}
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
    
    use home_io\core\Log as Log;
    use home_io\core\Page as Page;
    use home_io\i18n\i18n as i18n;
    use home_io\core\Input as Input;
    use home_io\templates\Template as Template;
    
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
         * The next lines should contain the class to load, and any parameters separated by a space, with each tuple appearing on a new line, e.g.
         * 
         * /my/api/definition
         *      class \namespace\to\MyAPIClass
         *      param1 value
         *      param2 value
         * 
         * /my/second/api/definition
         *      class \namespace\to\SecondAPIClass
         *      param1 value
         * 
         * 
         * @param type $filename
         */
        protected static function parseAPIConf($filename) {
            
            // Some debug
            Log::debug("Loading API definition from $filename");
            
            // Read and parse API definition file
            $api = array();
            $current = null;
            $f = fopen($filename, 'r');
            while (!feof($f)) {
                $line = trim(fgets($f));
                
                // Line of data
                if (strlen($line) > 0)
                {
                    if (!$current) {
                        $current = $line; // First line, must be the endpoint def
                        
                        Log::debug("Beginning new endpoint $current");
                    }
                    else
                    {
                        // Not the first line, tokenise the parameters
                        $params = explode(' ',$line, 2); // Tokenise parameters
                        $key = trim($params[0]);
                        $value = trim($params[1]);
                        
                        // Create definition entry if not already there
                        if (!isset($api[$current]))
                            $api[$current] = array();
                        
                        // Set value of api definition key
                        $api[$current][$key] = $value;
                        Log::debug("    Storing $key => $value");
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
                throw new APIException(\home_io\i18n\i18n::w ('api:exception:class_not_specified', array($endpoint)));

            if (!class_exists($definition['class'])) 
                throw new APIException(\home_io\i18n\i18n::w ('api:exception:class_not_found', array($definition['class'])));

            // Make sure the endpoint is in the correct format
            $endpoint = str_replace('\\', '/', $endpoint);
            $endpoint = trim($endpoint, '/ ');
            
            // If we've got here, the class has been specified and exists, so its safe to link it up
            self::$api[$endpoint] = $definition;
        }
        
        public static function pageHandler($page, $subpages) { 
                
                // What method are we calling
                list($method_format) = array_slice($subpages, -1);
                
                // What API endpoint are we calling?
                $call = implode('/', array_slice($subpages, 0, -1));
                Log::debug("Call made to $call endpoint, method $method_format");
                
                // Split method_format
                list($method, $format) = explode('.', $method_format);
                
                // Set viewtype 
                Input::set('_vt', 'json');
                Log::debug("Viewtype set to", Input::get('_vt'));
                
                // Sanity check method
                if (!$method)
                    throw new APIException(i18n::w ('api:exception:no_method'));
                
                // See if we have a class def
                if ($definition = self::$api[$call])
                {
                    Log::debug("Definition found, constructing API");
                    
                    // Build reflection class
                    $mirror = new \ReflectionClass($definition['class']);
                    
                    // Construct constructor parameters
                    $creation_parameters = array();
                    $constructor = $mirror->getConstructor();
                    if (!$constructor) 
                        throw new APIException(i18n::w('api:exception:no_constructor', array($definition['class'])));
                    if ($parameters = $constructor->getParameters())
                    {
                        foreach ($parameters as $param) {
                            $value = $definition[$param->name];
                            if ((!$value) && ($param->isDefaultValueAvailable())) // No value, but coded default present
                                $value = $param->getDefaultValue();
                            if (!$value) 
                                throw new APIException(i18n::w ('api:exception:missing_construction_parameter', array($param->name, $definition['class']))); // Still no value, throw an exception
                                
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
                        throw new APIException(i18n::w ('api:exception:could_not_create_instance', array($definition['class'])));
                    
                    // Get method, and see what parameters it needs
                    if (!$mirror_method = $mirror->getMethod($method))
                    {
                        Page::set404();
                        throw new APIException(i18n::w('api:exception:method_not_found', array($definition['class'], $method)));
                    }
                    
                    $method_parameters = array();
                    if ($parameters = $mirror_method->getParameters())
                    {
                        foreach ($parameters as $param) {
                            $value = $definition[$param->name];
                            if ((!$value) && ($param->isDefaultValueAvailable())) // No value, but coded default present
                                $value = $param->getDefaultValue();
                            if (!$value) 
                                throw new APIException(i18n::w ('api:exception:missing_method_parameter', array($param->name, $method))); // Still no value, throw an exception
                                
                            // We have a value, save it.
                            $method_parameters[] = $value;
                        }
                    }
                    
                    // Execute method call
                    if (count($method_parameters))
                        $result = call_user_func_array (array($object, $method), $method_parameters);
                    else 
                        $result = call_user_func (array($object, $method));
                    
                    // Output result
                    Template::getInstance()->outputPage("$method_format", $result);
                }
                else
                {
                    Page::set404();
                    throw new APIException(i18n::w('api:exception:api_not_found', array($call)));
                }
                
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
                        
            // Register API Page handler
            Page::create('api', '\home_io\api\API::pageHandler');
            
        }
        
    }
    
}
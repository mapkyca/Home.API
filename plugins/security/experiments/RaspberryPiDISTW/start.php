<?php

/**
 * @file
 * 
 * Raspberry Pi: Did I shut the window?
 * 
 * This is an example of how you hook up a home brew security device - such as the
 * stuff I've hacked together here: http://www.marcus-povey.co.uk/2013/06/26/did-i-shut-the-window-a-simple-raspberry-pi-home-security-system/
 * into the Home.API.
 * 
 * @package security
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 * @link http://www.marcus-povey.co.uk/2013/06/26/did-i-shut-the-window-a-simple-raspberry-pi-home-security-system/
 */

namespace security\experiments {
    
    // Use some Home.API classes
    use home_api\core\Log as Log;
    use home_api\i18n\i18n as i18n;
    
    /**
     * RaspberryPi "Did I Shut The Window?"
     */
    class RaspberryPiDISTW extends \home_api\plugins\Plugin {
        
        private $status;
        
        public function __construct() {
            
        }
        
        /**
         * Accept an update.
         * 
         * Expects a json POST body containing an associative array of:
         * 
         * 'Label' => 'Status', eg
         * 
         * {
         * 'Bathroom Window' => 'OPEN',
         * 'Back Door' => 'CLOSED',
         * ...
         * }
         * 
         */
        public function update() {
            $result = json_decode(\home_api\core\Input::getPOST());
            
            if ($result === NULL)
                throw new \home_api\plugins\PluginException(i18n::w ('raspberrypidistw:exception:no_json_data'));
            
            // Decode status
            $this->status = array();
            foreach ($result as $key => $value)
                $this->status[$key] =  $value;
            
            // Create couch store
            $uuid = \home_api\storage\nosql\NoSQLStorage::generateUUID($this, 'LastValues');
            $couch = \home_api\storage\nosql\CouchDB::getInstance();
            
            // See if there is an existing status
            $latest = $couch->retrieve($uuid);
            Log::debug("Retrieved: " . print_r($latest, true));
            if (!$latest)
                $latest = new stdClass();
            $latest->status = $this->status;
            
            // Store revision
            Log::debug("Updating UUID:$uuid with " . json_encode($latest));
            return $couch->store($uuid, $latest);
        }
        
        /**
         * Retrieve all details.
         */
        public function getAll() {
            Log::debug("Retrieving data from UUID:$uuid");
                
            $uuid = \home_api\storage\nosql\NoSQLStorage::generateUUID($this, 'LastValues');
            $couch = \home_api\storage\nosql\CouchDB::getInstance();
            
            $result = $couch->retrieve($uuid);
            Log::debug("Retrieved: " . print_r($result, true));
            if (!$result)
                throw new \home_api\plugins\PluginException(i18n::w('raspberrypidistw:exception:problem_getting_data'));
            
            return $result->status;
        }
        
        public function expose() {
            return array('update', 'getAll');
        }        
    }
    
}
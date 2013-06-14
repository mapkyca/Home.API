<?php
/**
 * @file
 * CouchDB Storage class
 * 
 * @package storage\nosql
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_api\storage\nosql {
    
    use home_api\i18n\i18n as i18n;
    use home_api\storage\StorageException as StorageException;
    
    /**
     * Definitions for CouchDB storage engine.
     */
    class CouchDB extends NoSQLStorage {
                
        private $dbname;
        private $hostURL;
        
        
        /**
         * Initialise DB connection.
         * @param string $dbname The database name
         * @param string $hostURL DB connection string, the default is fine for most people
         */
        public function __construct($dbname, $hostURL = 'http://localhost:5984/') {
            
            $this->dbname = trim($dbname, ' /');
            $this->hostURL = trim($hostURL, ' /') . '/';
            
            $this->newDatabase($this->dbname);
        }
        
        protected function query($method = COUCHDB_METHOD_GET, $uuid = '', array $parameters = null, $payload = '', $db = '') {
            
            global $version;
            
            // If we're referencing a UUID, make sure the URL will be correct
            if ($uuid)
                $uuid = "/$uuid";
            
            // Allow for DB override
            if (!$db)
                $db = $this->dbname;
            
            // Build Params
            $params = null;
            if ($parameters) {
                $params = array();
                foreach ($parameters as $key => $value)
                    $params[] = urlencode ($key) . '=' . urlencode($value);
                
            }
            
            // Curl installed
            if (!function_exists('curl_init')){
                throw new StorageException(i18n::w('couchdb:exception:curl_not_installed'));
            }
            
            // Headers
            $http_headers = array(
                'Accept: application/json,text/html,text/plain,*/*' , 
                'Content-Type: application/json'
            );
            
            // Initialise connection
            $url = "{$this->hostURL}{$db}{$uuid}";
            if (isset($params))
                $url .= '?' .implode('&', $params);
            $ch = curl_init($url);
            
            // Set basic options
            curl_setopt_array($ch, array(
                CURLOPT_USERAGENT => "Home.API-$version",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true
            ));
            
            // Decide method
            switch ($method) {
                case COUCHDB_METHOD_COPY:
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'COPY');
                    $http_headers[] = "Destination: " . json_encode($payload);
                    break;
                case COUCHDB_METHOD_DELETE:
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    break;
                case COUCHDB_METHOD_PUT:
                    curl_setopt($ch, CURLOPT_PUT, true);
                    if ($payload)
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                    break;
                case COUCHDB_METHOD_POST:
                    curl_setopt($ch, CURLOPT_POST, true);
                    if ($payload)
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                    break;
                case COUCHDB_METHOD_GET :
                default:
            }
            
            curl_setopt($http, CURLOPT_HTTPHEADER, $http_headers);
            
            $result = curl_exec($ch);
            
            curl_close($ch);
            
            if ($result === false)
                throw new StorageException(i18n::w('couchdb:exception:no_result'));
                
            $result = json_decode($result);
            
            if ($result === NULL)
                throw new StorageException(i18n::w('couchdb:exception:result_not_json'));
            
            return $result;
        }
        
        /**
         * Create a new database, will throw a StorageException if there's an error
         * @param type $db
         * @return boolean
         * @throws StorageException
         */
        public function newDatabase($db) {
            
            // See if the database exists
            $dbs = $this->query(COUCHDB_METHOD_GET, '', null, '', '_all_dbs');
            if (in_array($this->dbname, $dbs))
                    return true;
            
            // Doesn't so create
            $result = $this->query(COUCHDB_METHOD_PUT); // Put a new database
            if (isset($result->error))
                throw new StorageException($result->reason);
            return true;
        }

        /**
         * Delete a UUID
         * @param type $uuid The UUID to get
         * @param array $params Optional parameters
         * @return mixed The revision ID, or false
         */
        public function delete($uuid, array $params = null) {
            $result = $this->query(COUCHDB_METHOD_PUT, $uuid, $params, $data);
            if ($result->ok)
                return $result->rev;
            
            return false;
        }
        
        /**
         * Retrieve a UUID
         * @param type $uuid The UUID to get
         * @param array $params Optional parameters
         * @return mixed The revision ID, or false
         */
        public function retrieve($uuid, array $params = null) {
            return $this->query(COUCHDB_METHOD_GET, $uuid, $params);
            
            if ($result->ok)
                return $result->rev;
            
            return false;
        }

        /**
         * Store some data
         * @param type $uuid
         * @param type $data
         * @return mixed The revision ID, or false
         */
        public function store($uuid, $data, array $params = null) {
            $result = $this->query(COUCHDB_METHOD_PUT, $uuid, $params, $data);
            
            if ($result->ok)
                return $result->rev;
            
            return false;
        }
        
        
    }
    
    define('COUCHDB_METHOD_GET', 'GET');
    define('COUCHDB_METHOD_PUT', 'PUT');
    define('COUCHDB_METHOD_DELETE', 'DELETE');
    define('COUCHDB_METHOD_POST', 'POST');
    define('COUCHDB_METHOD_COPY', 'COPY'); // NOT IMPLEMENTED YET
}
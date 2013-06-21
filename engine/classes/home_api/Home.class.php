<?php

/**
 * @file
 * 
 * Main controller class.
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_api {
 
    /**
     * Main Home.API controller class.
     */
    class Home {

        /// Runtime variables
        public static $runtime;
        /// Config
        public static $config;

        
        /**
         * Engine and site initialisation.
         */
        public static function init(\stdClass $config = null) {
            if (!$config)
                $config = new stdClass;

            self::$config = $config;

            // Initialise some paths
            if (!isset(self::$config->wwwroot))
                self::$config->wwwroot = 'http://' . $_SERVER['SERVER_NAME'] . '/';
            self::$config->wwwroot = rtrim(self::$config->wwwroot, '/ ') . '/';
            if (!isset(self::$config->url))
                self::$config->url = self::$config->wwwroot;

            // Temporary directory	
            if (!isset(self::$config->temp))
                self::$config->temp = \home_api\core\Environment::getTempDir() . md5(self::$config->url) . '/';

            // Now ensure tmp dir is created
            @mkdir(self::$config->temp, 0777, true);


            // Where on the file system are the website files stored (this is usally safe to leave autodetected)
            if (!isset(self::$config->docroot))
                self::$config->docroot = dirname(dirname(dirname(dirname(__FILE__)))) . '/';

            // Work out a site secret if not set. This is used in security calculations, so shouldn't be guessable but consistent each run.
            if (!isset(self::$config->site_secret))
                self::$config->site_secret = md5(self::$config->docroot . self::$config->url);

            // Initialise runtime
            self::$runtime = new \stdClass();

            // Set some useful runtime variables
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { // Flag if this is called via an AJAX call
                // Flag that this is an ajax call
                self::$runtime->isAjaxCall = true;
            }
            
            // Boot Exceptions
            \home_api\core\Errors::init();
            
            // Boot subsystems
            \home_api\core\SubsystemFactory::registerConstructor('template', '\home_api\templates\Basic', array(array(
                self::$config->docroot . 'templates/Home.API/', 
                self::$config->docroot . 'templates/bootstrap/', 
                self::$config->docroot . 'templates/base/'
            )));
            \home_api\core\SubsystemFactory::registerConstructor('i18n', '\home_api\i18n\Basic', array(self::$config->docroot . 'i18n/', 'en'));
            \home_api\core\SubsystemFactory::registerConstructor('nosqlstorage', '\home_api\storage\nosql\CouchDB', array(
                isset(self::$config->couchdb) ? self::$config->couchdb : 'home_api', // DB Name, don't change unless you have to.
                isset(self::$config->couchdburl) ? self::$config->couchdburl : 'http://localhost:5984/' // Couch DB connection settings, again defaults fine for most
            ));
            
            // Boot these since we need to to support plugin specific boot templates and translations. May find a better way eventually
            \home_api\templates\Template::getInstance();
            \home_api\i18n\i18n::getInstance();
            
            // Boot plugins
            \home_api\plugins\Plugin::init();
            
            // Boot API
            \home_api\api\API::init(self::$config->docroot. 'def/'); // Boot API
            
        }

    }

}
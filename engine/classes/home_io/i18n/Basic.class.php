<?php

/**
 * @file
 * Default Site internationalisation engine.
 * 
 * 
 * @package i18n
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_io\i18n {

    /**
     * Default translation tool
     */
    class Basic extends i18n {

        private $basepath;
        private static $languages;
        private $current_language;

        public function __construct($path, $language = 'en') {
            include_once($path . $language . 'i18n.php');
            $this->current_language = $language;
            $this->basepath = $path;
        }
        
        public static function register(array $translations, $language = 'en') {
            if ((!$translations) || (count($translations) == 0))
                return false;

            if (!isset(self::$languages))
                self::$languages = array();

            if (!isset(self::$languages[$language]))
                self::$languages[$language] = $translations;
            else
                self::$languages[$language] = $translations + self::$languages[$language];

            return true;
        }

        public function write($key, array $parameters = null, $language = null) {
            if (!$language)
                $language = $this->current_language;

            if (isset(self::$languages[$language][$key])) {
                if ($parameters) {
                    array_walk($parameters, function(&$item, $key) {
                                $item = htmlentities($item, 0, "UTF-8");
                            });
                    return vsprintf(self::$languages[$language][$key], $parameters);
                }
                else
                    return self::$languages[$language][$key];
            }

            \home_io\core\Log::notice("Missing translation: $key ($language)");

            return $key;
        }

        public function translationExists($key, $language = null) {
            if (!$language)
                $language = $this->current_language;

            if (isset(self::$languages[$language][$key]))
                return true;

            return false;
        }

    }

}
<?php

/**
 * @file
 * Site wide exceptions.
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_io\core\exceptions {

    /**
     * Base class for all system exceptions.
     * 
     * This class provides a nice way to trap and extend error messages triggered by a thrown exception.
     */
    class HomeException extends \Exception {

        /**
         * Render the exception using the views system.
         */
        public function __toString() {
            $class = strtolower(get_class($this));
            
            \home_io\core\Log::debug("Exception thrown: " . $this->getMessage());

            $content = \home_io\templates\Template::v("exceptions/$class", array('exception' => $this));
            if ($content)
                return $content;

            $content = \home_io\templates\Template::v('exceptions/__default', array('exception' => $this));
            if ($content)
                return $content;

            return false;
        }

    }

}
<?php

/**
 * @file
 * Basic session handling code
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */


namespace home_api\core {

    /**
     * Basic session management.
     */
    class Session {

        public static function init() {
            $session_settings = session_get_cookie_params();
            session_set_cookie_params(
                    $session_settings['lifetime'], 
                    $session_settings['path'], 
                    $session_settings['domain'], 
                    $session_settings['secure'], 
                    true // Set HTTPOnly cookies
            );

            session_start();

            // TODO: More session code
        }

    }

}
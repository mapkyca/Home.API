<?php

/**
 * @file
 * Error handling functions
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license The MIT License (see LICENCE.txt), other licenses available.
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @link http://www.marcus-povey.co.uk
 */

namespace home_io\core {

    /**
     * Error handling functions.
     */
    class Errors {

        /**
         * Trap PHP error message.
         * 
         * @see http://www.php.net/set-error-handler
         * @param int $errno The level of the error raised
         * @param string $errmsg The error message
         * @param string $filename The filename the error was raised in
         * @param int $linenum The line number the error was raised at
         * @param array $vars An array that points to the active symbol table at the point that the error occurred
         */
        public static function __error_handler($errno, $errmsg, $filename, $linenum, $vars) {

            $error = date("Y-m-d H:i:s (T)") . ": \"" . $errmsg . "\" in file " . $filename . " (line " . $linenum . ")";

            switch ($errno) {
                case E_USER_ERROR:
                    \home_io\core\Log::error($error);
                    break;

                case E_WARNING :
                case E_USER_WARNING :
                    \home_io\core\Log::warning($error);
                    break;

                default:
                    \home_io\core\Log::log_echo($error, 'DEBUG');
            }

            return true;
        }

        /**
         * Custom exception handler.
         * This function catches any thrown exceptions and handles them appropriately.
         *
         * @see http://www.php.net/set-exception-handler
         * @param Exception $exception The exception being handled
         */
        public static function __exception_handler($exception) {

            ob_end_clean(); // Clear existing / half empty buffer
            
            // Log exception
            \home_io\core\Log::log_echo($exception->getMessage(), 'EXCEPTION');

            // If this is a platform exception then render it creatively, otherwise enforce the default
            if ($exception instanceof \home_io\core\exceptions\HomeException)
                $body = "$exception";
            else
                $body = \home_io\templates\Template::v('exceptions/__default', array('exception' => $exception));

            \home_io\templates\Template::getInstance()->outputPage(\home_io\i18n\i18n::w('exception:title'), $body);
        }

        public static function init() {
            // Now set php error handlers
            if ((isset(\home_io\Home::$config->debug)) && (\home_io\Home::$config->debug))
                set_error_handler('\home_io\core\Errors::__error_handler', E_ALL & E_STRICT);
            else
                set_error_handler('\home_io\core\Errors::__error_handler', E_ALL & ~E_NOTICE); // Hide notice level errors when not in debug

            set_exception_handler('\home_io\core\Errors::__exception_handler');
        }

    }

}
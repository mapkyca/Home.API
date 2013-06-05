<?php

/**
 * @file
 * Error handling functions
 * 
 * @package core
 * @copyright Marcus Povey 2013
 * @license $$LICENCE$$
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

            // Lazy loader sometimes doesn't handle errors too well, so load stats classes if not already present.
            if (!class_exists('Stats'))
                require_once(dirname(__FILE__) . '/Stats.class.php');
            if (!class_exists('EtsyStatsdStats'))
                require_once(dirname(__FILE__) . '/EtsyStatsdStats.class.php');

            $error = date("Y-m-d H:i:s (T)") . ": \"" . $errmsg . "\" in file " . $filename . " (line " . $linenum . ")";

            try {
                Stats::i('error.total');

                switch ($errno) {
                    case E_USER_ERROR:
                        Stats::i('error.error');
                        Site::error($error);
                        break;

                    case E_WARNING :
                    case E_USER_WARNING :
                        Stats::i('error.warning');
                        Site::warning($error);
                        break;

                    default:
                        Stats::i('error.debug');
                        Site::log_echo($error, 'DEBUG');
                }
            } catch (Exception $e) {
                die($e->getMessage());
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

            // Lazy loader sometimes doesn't handle errors too well, so load stats classes if not already present.
            if (!class_exists('Stats'))
                require_once(dirname(__FILE__) . '/Stats.class.php');

            // Log exception (and we can't have any exceptions)
            try {
                Stats::i('exception.total');
                Stats::i('exception.' . strtolower(get_class($exception)));
            } catch (Exception $e) {
                die($e->getMessage());
            }

            ob_end_clean(); // Clear existing / half empty buffer
            // Log exception
            Site::log_echo($exception->getMessage(), 'EXCEPTION');

            // Optionally email exception
            if (Site::$config->email_exceptions == true) {
                mail(
                        Site::$config->admin_email, 'EXCEPTION ' . Site::$config->name . " : " . $exception->getMessage(), $exception->getTraceAsString()
                );
            }

            // If this is a platform exception then render it creatively, otherwise enforce the default
            if ($exception instanceof SiteException)
                $body = "$exception";
            else
                $body = Template::v('exceptions/__default', array('exception' => $exception));

            Template::getInstance()->outputPage(i18n::w('exception:title'), $body);
        }

        public static function init() {
            // Now set php error handlers
            if (Site::$config->debug)
                set_error_handler('Errors::__error_handler', E_ALL & E_STRICT);
            else
                set_error_handler('Errors::__error_handler', E_ALL & ~E_NOTICE); // Hide notice level errors when not in debug

            set_exception_handler('Errors::__exception_handler');
        }

    }

}
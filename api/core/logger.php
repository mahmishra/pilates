<?php

/**
 * This class is used for logging
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
define('EBIZU_LOG_LEVEL_ERROR', 1);
define('EBIZU_LOG_LEVEL_WARNING', 2);
define('EBIZU_LOG_LEVEL_INFORMATION', 3);
define('EBIZU_LOG_LEVEL_DEBUG', 4);
define('EBIZU_LOG_LEVEL_VERBOSE', 5);
define('EBIZU_LOG_LEVEL', EBIZU_LOG_LEVEL_VERBOSE);

class EbLogger {

    /**
     * 
     * @param int $level
     * @param String $message
     */
    public static function log($level, $message) {
        echo '<pre>'.$level.' -> '.$message.'</pre>';
    }

    /**
     * Method used to log error
     * @param String $message message
     */
    public static function e($message) {
        EbLogger::log(EBIZU_LOG_LEVEL_ERROR, $message);
    }

    /**
     * Method used to log warning
     * @param String $message message
     */
    public static function w($message) {
        EbLogger::log(EBIZU_LOG_LEVEL_WARNING, $message);
    }

    /**
     * Method used to log information
     * @param String $message message
     */
    public static function i($message) {
        EbLogger::log(EBIZU_LOG_LEVEL_INFORMATION, $message);
    }

    /**
     * Method used to log debug
     * @param String $message message
     */
    public static function d($message) {
        EbLogger::log(EBIZU_LOG_LEVEL_DEBUG, $message);
    }

    /**
     * Method used to log verbose
     * @param String $message message
     */
    public static function v($message) {
        EbLogger::log(EBIZU_LOG_LEVEL_VERBOSE, $message);
    }

}

?>

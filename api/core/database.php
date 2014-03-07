<?php

/**
 * This class is used to manage database
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
class DB {

    const HOST = 'shopsmartdb.cyfkaa5qbt52.ap-southeast-1.rds.amazonaws.com';
    const PORT = 3306;
    const USER = 'shopsmart';
    const PASS = 'shopsmart4$';
    const DBNAME = 'shopsmart_db';

    /**
     * Method used to get server name
     * @return String server name
     */
    public static function dbHost() {
        return DB::HOST;
    }

    /**
     * Method used to get server port
     * @return int server port
     */
    public static function dbPort() {
        return DB::PORT;
    }

    /**
     * Method used to get username
     * @return String username
     */
    public static function dbUsername() {
        return DB::USER;
    }

    /**
     * Method used to get password
     * @return String password
     */
    public static function dbPassword() {
        return DB::PASS;
    }

    /**
     * Method used to get database name
     * @return String database name
     */
    public static function dbName() {
        return DB::DBNAME;
    }

    /**
     * Method used to get dsn
     * @return string database dsn
     */
    public static function dsn() {
        return 'mysql:host=' . DB::HOST . ';port=' . DB::PORT . ';dbname=' . DB::DBNAME;
    }

    /**
     * Method used to get pdo instance
     * @return PDO instance of PDO
     */
    public static function PDO() {
        return new PDO(DB::dsn(), DB::USER, DB::PASS);
    }

}

?>

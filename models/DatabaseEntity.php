<?php

/**
 * Relates to any object that can access a database. Acts as a centralised database settings file. All model classes that access the database should inherit from this class
 */
abstract class DatabaseEntity{    
    /**
     * Returns a database object. Designed to allow child classes to use a related object in static methods, which would be impossible if it where an object itself
     *
     * @return Database
     */
    protected static function DB(){
        include_once "Database.php";

        if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_ADDR"] == "127.0.0.1"){
            $serverName = "localhost";
            $username = "root";
            $password = "";
            $dbName = "SportsWarehouse";
        } else{
            $serverName = "localhost";
            $username = "magenta02";
            $password = "father71";
            $dbName = "magenta02";
        }

        return new Database($serverName, $username, $password, $dbName);
    }
}
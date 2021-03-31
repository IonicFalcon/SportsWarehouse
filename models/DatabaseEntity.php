<?php

/**
 * Relates to any object that can access a database
 */
abstract class DatabaseEntity{
    protected static function DB(){
        include_once "Database.php";
        include "settings/DBSettings.php";

        return new Database($serverName, $username, $password, $dbName);
    }
}
<?php

if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_ADDR" == "127.0.0.1"]){
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
<?php

session_start();

if(isset($_SESSION["LoggedInUser"])){
    unset($_SESSION["LoggedInUser"]);
    header("Location: index.php");
    die();
}
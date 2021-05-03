<?php
session_start();

if(isset($_SESSION["LoggedInUser"])){
    header("Location: index.php");
    die();
}

include "templates/login.html.php";
<?php
session_start();

if(isset($_SESSION["LoggedInUser"])){
    if(!isset($_GET["reauthorise"])){
        header("Location: index.php");
        die();
    } else{
        $error = "Please log in again before continuing.";
    }
}

$pageTitle = "Login - Sports Warehouse";

ob_start();

include "templates/login.html.php";
$mainOutput = ob_get_clean();

include "templates/loginLayout.html.php";
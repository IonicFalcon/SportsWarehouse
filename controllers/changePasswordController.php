<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();

    include "../models/Admin.php";
    $admin = unserialize($_SESSION["LoggedInUser"]);

    if(Admin::Login($admin->UserName, $_POST["originPass"])){
        $errorMessage = $admin->ChangePassword($_POST["newPass"]);
    }else {
        $errorMessage = "Your original password is incorrect. Please try again.";
    }

    if(!$errorMessage){
        header("Location: ../login.php?reauthorise=index.php");
        die();
    }else{
        $_SESSION["ErrorInfo"] = $errorMessage;
        header("Location: ../changePassword.php");
        die();
    }

} else{
    header("Location: ../index.php");
    die();
}
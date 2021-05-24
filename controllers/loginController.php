<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();

    include "../models/Admin.php";
    $admin = Admin::Login($_POST["username"], $_POST["password"]);

    if($admin){
        $_SESSION["LoggedInUser"] = serialize($admin);

        header("Location: ../" . $_POST["reauthPage"] ?? "index.php");
        die();
    } else{
        $_SESSION["ErrorInfo"] = "Incorrect Username or Password. Please try again";
        header("Location: ../login.php" . (isset($_POST["reauthPage"]) ? "?reauthorise=" . $_POST["reauthPage"] : null ));
        die();
    }
} else{
    header("Location: ../index.php");
    die();
}
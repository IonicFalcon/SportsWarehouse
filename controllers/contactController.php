<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include "../models/FormValidator.php";

    $requiredFields = [
        "firstName",
        "lastName",
        "email",
        "question"
    ];

    $validator = new FormValidator();

    foreach($requiredFields as $field){
        $validator->CheckEmpty($field);
    }

    $validator->CheckEmail("email");

    if($validator->isValid){
        header("Location: ../contactThanks.php");
        die();
    } else{
        session_start();
        $_SESSION["ErrorFields"] = serialize($validator);
        $_SESSION["OldData"] = $_POST;

        header("Location: ../contactUs.php");
        die();
    }


} else{
    header("Location: ../index.php");
    die();
}
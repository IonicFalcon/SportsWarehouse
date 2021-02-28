<?php

//As this is a controller, no user should be able to see this file
//Hence, redirect to appropriate page if a user were to get here
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $requiredFields = [
        "firstName",
        "lastName",
        "email",
        "question"
    ];

    foreach($requiredFields as $field){
        $value = $_POST[$field];

        if(empty($value)){

        }
    }
} else{
    header("Location:  ../comingSoon.php");
    die();
}
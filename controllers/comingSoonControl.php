<?php

//As this is a controller, no user should be able to see this file
//Hence, redirect to appropriate page if a user were to get here
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Validation on server-side makes sure the data is validated even if JavaScript is disable and required tag is removed
    $requiredFields = [
        "firstName",
        "lastName",
        "email",
        "question"
    ];

    //Required fields that don't have a value
    $missingFields = [];

    foreach($requiredFields as $field){
        $value = $_POST[$field];

        //If a required field doesn't have a value, push field name to missing fields
        if(empty($value)){
            array_push($missingFields, $field);
        }
    }

    if(sizeof($missingFields) > 0){
        session_start();

        //Put missing fields into session and redirect back to original form page
        $_SESSION["ErrorFields"] = $missingFields;
        header("Location: ../comingSoon.php");
        die();
    } else{
        //Redirect to acknowlegement page
        header("Location: ../comingSoon_Thanks.html");
        die();
    }
} else{
    header("Location:  ../comingSoon.php");
    die();
}
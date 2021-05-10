<?php
include "../models/Category.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $categories = Category::GetAllCategories();
    echo '{"data":' . json_encode($categories) . "}";
    die();
} else{
    $errorMessage = null;

    switch($_POST["method"]){
        case "Add":
            break;

        case "Edit":
            $errorMessage = Category::UpdateCategory($_POST["categoryID"], $_POST["categoryName"]);
            break;

        case "Delete":
            break;
    }

    if($errorMessage){
        http_response_code(500);
        echo '{"error": "' . $errorMessage . '"}';
        die();
    } else{
        die();
    }
}
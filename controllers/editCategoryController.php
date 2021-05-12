<?php
include "../models/Category.php";
$categories = Category::GetAllCategories();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    echo '{"data":' . json_encode($categories) . "}";
    die();
} else{
    $errorMessage = null;

    switch($_POST["method"]){
        case "Add":
            foreach($categories as $category){
                if(strtolower(trim($category->CategoryName)) === strtolower(trim($_POST["categoryName"]))){
                    $statusCode = 400;
                    $errorMessage = "A category of that name already exists.";
                    break;
                }
            }
            if(isset($errorMessage)) break;

            $errorMessage = Category::AddCategory($_POST["categoryName"]);
            break;

        case "Edit":
            foreach($categories as $category){
                if(strtolower(trim($category->CategoryName)) === strtolower(trim($_POST["categoryName"]))){
                    $statusCode = 400;
                    $errorMessage = "A category of that name already exists.";
                    break;
                }
            }
            if(isset($errorMessage)) break;

            $errorMessage = Category::UpdateCategory($_POST["categoryID"], $_POST["categoryName"]);
            break;

        case "Delete":
            break;
    }

    if($errorMessage){
        //Unless otherwise stated, HTTP code will be 500
        http_response_code($statusCode ?? 500);
        echo '{"error": "' . $errorMessage . '"}';
        die();
    } else{
        echo json_encode(Category::GetAllCategories());
        die();
    }
}
<?php
include "../models/Item.php";
$items = Item::GetAllItems();

foreach($items as $item){
    $item->ItemName = htmlentities($item->ItemName);
    $item->Description = htmlentities($item->Description);
    $item->Category->CategoryName = htmlentities($item->Category->CategoryName);
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    echo '{"data":' . json_encode($items) . "}";
    die();
} else{
    $errorMessage = null;

    switch($_POST["method"]){
        case "Add":
            $newItem = new Item();

            $errorMessage = ItemFromPost($newItem);
            if($errorMessage){
                $statusCode = $errorMessage[0];
                $errorMessage = $errorMessage[1];
                break;
            }

            $errorMessage = Item::AddItem($newItem);
            break;
    
        case "Edit":
            $editItem = new Item();

            $editItem->ItemID = $_POST["itemID"];

            $errorMessage = ItemFromPost($editItem);
            if($errorMessage){
                $statusCode = $errorMessage[0];
                $errorMessage = $errorMessage[1];
                break;
            }

            $errorMessage = Item::EditItem($editItem);
            break;

        case "Delete":
            $errorMessage = Item::DeleteItem($_POST["itemID"]);
            break;
    }

    if($errorMessage){
        http_response_code($statusCode ?? 500);
        echo '{"error": "' . $errorMessage . '"}';
        die();
    } else{
        echo json_encode(null);
        die();
    }
}

function ItemFromPost(&$item){
    $item->ItemName = $_POST["itemName"];
    $item->Price = $_POST["itemPrice"];
    $item->SalePrice = $_POST["itemSalePrice"] ?? null;
    $item->Description = $_POST["itemDescription"] ?? null;
    $item->Featured = isset($_POST["itemFeatured"]);
    $item->Category = Category::GetCategoryFromID(($_POST["itemCategory"]));

    $errorMessage = !empty($_FILES["itemPhoto"]["name"]) ? SaveItemImage($_FILES["itemPhoto"]) : null;

    if(!$errorMessage){
        $item->Photo = $_FILES["itemPhoto"]["name"] ?? null;
    } else{
        return $errorMessage;
    }
}

function SaveItemImage($image){
    $itemImageLocation = "../images/productImages/";

    $validImageTypes = ["image/jpeg", "image/png", "image/gif"];
    
    if(!in_array($image["type"], $validImageTypes)){
        return [
            400,
            "The file uploaded doesn't appear to be an image. Please try again."
        ];
    }

    switch($image["error"]){
        case UPLOAD_ERR_INI_SIZE:
            return [
                400,
                "The file uploaded is too large. Please make sure your file is under " . (int)ini_get("upload_max_filesize") . "MB and try again."
            ];
        case UPLOAD_ERR_NO_FILE:
            return [
                400,
                "No file was uploaded. Please try again."
            ];
        case UPLOAD_ERR_NO_TMP_DIR:
        case UPLOAD_ERR_CANT_WRITE:
            return [
                500,
                "PHP Upload Error Code: " .  $image["error"]
            ];
    }

    $moved = @move_uploaded_file($image["tmp_name"], $itemImageLocation . basename($image["name"]));

    if(!$moved){
        return [
            500,
            "File wasn't uploaded due to an unknown error"
        ];
    }
}
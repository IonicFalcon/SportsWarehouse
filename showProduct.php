<?php
if(isset($_GET["id"]) && $_GET["id"] != ""){
    require_once "models/Item.php";
    require_once "models/Category.php";
    
    $item = Item::GetItemFromID($_GET["id"]);
    $categories = Category::GetAllCategories();

    //Query returned nothing, therefore no item exists with given ID; Return to homepage
    if($item === null){
        header("Location: index.php");
        die();
    }

    require_once "models/Admin.php";
    $admin = Admin::AdminFunction();

    $pageTitle = $item->ItemName . " - Sports Warehouse";
    $JSSources = [
        ["js/showProduct.js", true]
    ];

    ob_start();

    include "templates/showProduct.html.php";

    $mainOutput = ob_get_clean();
    include "templates/layout.html.php";

} else{
    header("Location: index.php");
    die();
}
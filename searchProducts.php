<?php

if(!isset($_GET["cat"]) && !isset($_GET["search"])){
    header("Location: index.php");
    die();
}

require_once "models/Item.php";
require_once "models/Category.php";
require_once "models/FormValidator.php";

if(isset($_GET["cat"]) && $_GET["cat"] != ""){
    $category = Category::GetCategoryFromID($_GET["cat"]);

    $baseQuery = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item` WHERE `CategoryID` = :catID ";
    $param = [
        ":catID" => $category->CategoryID
    ];

    $pageTitle = $category->CategoryName . " - Sports Warehouse";

} else{
    $baseQuery = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item` WHERE `ItemName` LIKE :query ";
    $param = [
        ":query" => "%"  . $_GET["search"] . "%"
    ];

    $pageTitle = "Search Results - Sports Warehouse";
}

if(isset($_GET["sort"]) && $_GET["sort"] != ""){
    switch($_GET["sort"]){
        case "AToZ":
            $baseQuery .= "ORDER BY `ItemName`";
            break;
        case "ZToA":
            $baseQuery .= "ORDER BY `ItemName` DESC";
            break;
        case "priceLow":
            $baseQuery .= "ORDER BY `SalePrice`, `Price`";
            break;
        case "priceHigh":
            $baseQuery .= "ORDER BY `SalePrice` DESC, `Price` DESC";
            break;
        case "featured":
            $baseQuery .= "AND `Featured` = 1";
            break;
    }
} else{
    $baseQuery .= "ORDER BY `ItemName`";
}

$items = Item::SearchForItems($baseQuery, $param);
$categories = Category::GetAllCategories();

$JSSources = [
    "js/searchProducts.js"
];

ob_start();

include "templates/searchProducts.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";

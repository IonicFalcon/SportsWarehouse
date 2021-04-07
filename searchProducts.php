<?php
/**
 * Build upon a base query to include extra details from query string. For example, how data should be sorted or limited
 *
 * @param &string $baseQuery
 * @return void
 */
function BuildQuery(&$baseQuery){
    if(isset($_GET["sort"]) && $_GET["sort"] != ""){
        switch($_GET["sort"]){
            case "AToZ":
                $baseQuery .= "ORDER BY `ItemName` ";
                break;
            case "ZToA":
                $baseQuery .= "ORDER BY `ItemName` DESC ";
                break;
            case "priceLow":
                $baseQuery .= "ORDER BY `SalePrice` DESC, `Price` DESC ";
                break;
            case "priceHigh":
                $baseQuery .= "ORDER BY `SalePrice`, `Price` ";
                break;
            case "featured":
                $baseQuery .= "AND `Featured` = 1 ";
                break;
        }
    }

    $limit = 6;
    $page = 0;

    if(isset($_GET["limit"]) && $_GET["limit"] != ""){
        $limit = $_GET["limit"];
    }

    if(isset($_GET["page"]) && $_GET["page"] != ""){
        $page = $_GET["page"];
    }

    $baseQuery .= "LIMIT $limit OFFSET " . $limit * $page;

    $baseQuery = trim($baseQuery);
}

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

BuildQuery($baseQuery);
$items = Item::SearchForItems($baseQuery, $param);
$categories = Category::GetAllCategories();

$searchStart = 1;
$limit = 6;

if(isset($_GET["limit"]) && $_GET["limit"] != ""){
    $limit = $_GET["limit"];
    $page = 0;
    
    if(isset($_GET["page"]) && $_GET["page"] != ""){
        $page = $_GET["page"];
    }
    
    $searchStart = $limit * $page + 1;
    $searchEnd = $searchStart + $limit;
}


$totalItems = sizeof($items);
if($limit > $totalItems){
    $searchEnd = $totalItems;
}

$JSSources = [
    "js/searchProducts.js"
];

ob_start();

include "templates/searchProducts.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";

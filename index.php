<?php

$pageTitle = "Sports Warehouse";

//Add CSS and JavaScript file locations needed for this page
$CSSSources = [
    "https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css"
];
$JSSources = [
    "https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js",
    "js/index.js"
];

require_once "models/Item.php";
require_once "models/Category.php";

$featuredItems = Item::GetFeaturedItems();
$categories = Category::GetAllCategories();

ob_start();

include "templates/index.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
<?php

if(isset($_GET["id"]) && $_GET["id"] != ""){
    require_once "models/Item.php";
    require_once "models/Category.php";
    
    $item = Item::GetItemFromID($_GET["id"]);
    $categories = Category::GetAllCategories();

    $pageTitle = $item->ItemName . " - Sports Warehouse";
    $JSSources = [
        [
            // js/showProduct.js uses a module, so it has to have a boolean to declare it as one
            "js/showProduct.js",
            true
        ],
        "https://cdn.jsdelivr.net/npm/js-image-zoom/js-image-zoom.min.js"
    ];

    ob_start();

    include "templates/showProduct.html.php";

    $mainOutput = ob_get_clean();
    include "templates/layout.html.php";

}
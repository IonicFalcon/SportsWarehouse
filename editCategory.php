<?php

require_once "models/Admin.php";
$admin = Admin::RestrictPage();

require_once "models/Category.php";
$categories = Category::GetAllCategories();

if(isset($_GET["id"])){
    $editCategory = Category::GetCategoryFromID($_GET["id"]);
}

$JSSources = [
    "https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js",
    [
        "js/editCategory.js",
        true
    ]
];

$CSSSources = [
    "https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"
];

$pageTitle = "Edit Categories - Sports Warehouse";

ob_start();

include "templates/editCategory.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
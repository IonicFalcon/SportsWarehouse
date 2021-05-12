<?php

require_once "models/Admin.php";
$admin = Admin::RestrictPage();

require_once "models/Category.php";
$categories = Category::GetAllCategories();

$JSSources = [
    "https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js",
    "js/editItem.js"
];

$CSSSources = [
    "https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"
];

$pageTitle = "Edit Items - Sports Warehouse";

ob_start();

include "templates/editItem.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
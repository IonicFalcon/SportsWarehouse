<?php

require_once "models/Admin.php";
$admin = Admin::RestrictPage();

require_once "models/Category.php";
$categories = Category::GetAllCategories();

$pageTitle = "Change Theme - Sports Warehouse";

ob_start();

$JSSources = [
    "js/changeTheme.js"
];

include "templates/changeTheme.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
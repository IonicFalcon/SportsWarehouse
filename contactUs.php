<?php

require_once "models/Category.php";

$categories = Category::GetAllCategories();

$pageTitle = "Contact Us - Sports Warehouse";

$JSSources = [
    "js/contact.js"
];

ob_start();

include "templates/contact.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";

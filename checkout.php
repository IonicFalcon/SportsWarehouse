<?php

require_once "models/Category.php";
require_once "models/ShoppingCart.php";
require_once "models/Item.php";

$categories = Category::GetAllCategories();

$pageTitle = "Checkout - Sports Warehouse";

$JSSources = [
    ["js/checkout.js", true]
];

ob_start();

include "templates/checkout.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
<?php

require_once "models/Category.php";
require_once "models/ShoppingCart.php";
require_once "models/Item.php";

$categories = Category::GetAllCategories();

$pageTitle = "Shopping Cart - Sports Warehouse";

ob_start();

include "templates/viewCart.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
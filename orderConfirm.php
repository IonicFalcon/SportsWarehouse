<?php

require_once "models/Order.php";
require_once "models/Category.php";

$categories = Category::GetAllCategories();

$pageTitle = "Order Confirmation - Sports Warehouse";

ob_start();

include "templates/orderConfirm.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
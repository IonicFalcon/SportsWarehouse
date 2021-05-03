<?php

require_once "models/Category.php";

$categories = Category::GetAllCategories();

$pageTitle = "Thank You! - Sports Warehouse";

ob_start();

include "templates/contactThanks.html.php";

$mainOutput = ob_get_clean();
include "templates/layout.html.php";
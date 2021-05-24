<?php

require_once "models/Admin.php";
$admin = Admin::RestrictPage();

$admin->Reauthorise(true);

$pageTitle = "Change Password - Sports Warehouse";

$JSSources = [
    "js/changePassword.js"
];

ob_start();

include "templates/changePassword.html.php";

$mainOutput = ob_get_clean();
include "templates/loginLayout.html.php";
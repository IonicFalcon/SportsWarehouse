<?php
include "../models/Item.php";
$items = Item::GetAllItems();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    echo '{"data":' . json_encode($items) . "}";
    die();
}
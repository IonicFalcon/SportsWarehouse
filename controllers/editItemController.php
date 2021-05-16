<?php
include "../models/Item.php";
$items = Item::GetAllItems();

foreach($items as $item){
    $item->ItemName = htmlentities($item->ItemName);
    $item->Description = htmlentities($item->Description);
    $item->Category->CategoryName = htmlentities($item->Category->CategoryName);
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    echo '{"data":' . json_encode($items) . "}";
    die();
}
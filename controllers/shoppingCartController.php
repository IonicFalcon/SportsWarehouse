<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
    include "../models/Item.php";

    if(isset($_SESSION["ShoppingCart"])){
        $shoppingCart = unserialize($_SESSION["ShoppingCart"]);
    } else{
        include "../models/ShoppingCart.php";
        $shoppingCart = new ShoppingCart();
    }

    $item = Item::GetItemFromID($_POST["itemID"]);
    $item->Quantity = $_POST["quantity"];

    array_push($shoppingCart->Items, $item);
    $_SESSION["ShoppingCart"] = serialize($shoppingCart);

    $returnData = ["ShoppingCartLength" => sizeof($shoppingCart->Items)];
    json_encode($returnData);
} else{
    header("Location: ../index.php");
    die();
}
<?php

//No user should be able to see this page; if not POST, redirect them back to the homepage
if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
    include "../models/Item.php";
    include "../models/ShoppingCart.php";

    //Check if a shopping cart session already exist; if not, create a new one
    if(isset($_SESSION["ShoppingCart"])){
        $shoppingCart = unserialize($_SESSION["ShoppingCart"]);
    } else{
        $shoppingCart = new ShoppingCart();
    }

    //Store Item data and quantity in Item object
    $item = Item::GetItemFromID($_POST["itemID"]);
    $item->Quantity = $_POST["quantity"];

    //Add Item to Shopping Cart and put Shopping Cart object back in Session
    $shoppingCart->AddItem($item);
    $_SESSION["ShoppingCart"] = serialize($shoppingCart);

    //Format and echo data to be returned as JSON
    $returnData = ["CartItems" => $shoppingCart->ItemCount()];
    echo json_encode($returnData);
} else{
    header("Location: ../index.php");
    die();
}
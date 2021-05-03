<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // If it's the first shipping info half, store its data in a session and return
    if(isset($_POST["AJAXHalf"])){
        session_start();
        $_SESSION["ShippingInfo"] = serialize($_POST);
        die();
    }
    // Else it must be the payment info

    session_start();
    include "../models/ShoppingCart.php";
    include "../models/Order.php";

    // Merge two halves together and remove now unnesscary session variable
    $orderInfo = array_merge(unserialize($_SESSION["ShippingInfo"]), $_POST);
    unset($_SESSION["ShippingInfo"]);

    $shoppingCart = unserialize($_SESSION["ShoppingCart"]);

    // Create a new Order object and process the order
    $order = new Order($orderInfo, $shoppingCart);
    $errorMessage = $order->ProcessOrder();

    // If an error is returned, capture the error message in a session and redirect back to cart page
    if(!$errorMessage){
        //Else destroy the shopping cart session, store order details, and redirect to confirmation page
        unset($_SESSION["ShoppingCart"]);
        $_SESSION["OrderDetails"] = serialize($order);
        header("Location: ../orderConfirm.php");
        die();
    } else{
        $_SESSION["DBError"] = $errorMessage;
        header("Location: ../viewCart.php");
        die();
    }

} else{
    header("Location: ../index.php");
    die();
}
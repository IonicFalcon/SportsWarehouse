<?php
function AddToCart(&$cart){
     //Store Item data and quantity in Item object
     $item = Item::GetItemFromID($_POST["itemID"]);
     $item->Quantity = $_POST["quantity"];
 
     //Add Item to Shopping Cart and put Shopping Cart object back in Session
     $cart->AddItem($item);
}

function EditCart(&$cart){
    foreach($cart->Items as $item){
        if($item->ItemName === $_POST["itemName"]){
            $item->Quantity = $_POST["quantity"];
            break;
        }
    }
}

function RemoveFromCart(&$cart){
    $index = null;

    for($i = 0; $i < sizeof($cart->Items); $i++){
        if($cart->Items[$i]->ItemName === $_POST["itemName"]){
            $index = $i;
            break;
        }
    }

    unset($cart->Items[$index]);
    $cart->Items = array_values($cart->Items);
}

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

    //As this controller is used across multiple files, this switch is used to redirect to the approriate method
    switch($_POST["cartMethod"]){
        case "Add":
            AddToCart($shoppingCart);
            break;
        case "Edit":
            EditCart($shoppingCart);
            break;
        case "Delete":
            RemoveFromCart($shoppingCart);
            break;
    }

   
    $_SESSION["ShoppingCart"] = serialize($shoppingCart);

    //Format and echo data to be returned as JSON
    $returnData = [
        "CartItems" => $shoppingCart->ItemCount(),
        "CartSubtotal" => number_format((float)$shoppingCart->CalculateSubtotal(), 2),
        "CartDiscount" => number_format((float)$shoppingCart->CalculateDiscount(), 2),
        "CartTotal" => number_format((float)$shoppingCart->CalculatePrice(), 2)
    ];

    if($_POST["cartMethod"] == "Edit"){
        foreach($shoppingCart->Items as $item){
            if($item->ItemName === $_POST["itemName"]){
                $returnData += ["ItemSubtotal" => number_format((float)$item->GetSubtotalPrice(), 2)];
                break;
            }
        }
    }

    echo json_encode($returnData);
} else{
    header("Location: ../index.php");
    die();
}